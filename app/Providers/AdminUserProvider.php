<?php


namespace App\Providers;

use App\Models\AdminUser;
use App\Repositories\AdminMenuRepository;
use App\Repositories\AdminUserGroupMenuConfigRepository;
use App\Repositories\AdminUserGroupSiteConfigRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class AdminUserProvider implements UserProvider
{

    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The Eloquent user model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new database user provider.
     *
     * @param \Illuminate\Contracts\Hashing\Hasher $hasher
     * @param string $model
     * @return void
     */
    public function __construct(HasherContract $hasher, $model)
    {
        $this->model = $model;
        $this->hasher = $hasher;
    }

    /**
     * @inheritDoc
     */
    public function retrieveById($identifier)
    {
        // TODO: Implement retrieveById() method.
    }

    /**
     * @inheritDoc
     */
    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
    }

    /**
     * @inheritDoc
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
    }

    /**
     * @inheritDoc
     */
    public function retrieveByCredentials(array $credentials)
    {

        if (empty($credentials) ||
            (count($credentials) === 1 &&
                Str::contains($this->firstCredentialKey($credentials), 'password')))
        {
            return;
        }

        $adminUserModel = $this->newModelQuery();

        $adminUserModel
            ->leftJoin('admin_user_group', 'admin_user.admin_user_group_id', '=', 'admin_user_group.id')
            ->select
            (
                'admin_user.password',
                'admin_user.id as admin_user_id',
                'admin_user.name as admin_user_name',
                'admin_user.account as admin_user_account',
                'admin_user.email as admin_user_email',
                'admin_user.admin_user_group_id as admin_user_group_id',
                'admin_user_group.name as admin_user_group_name',
                'admin_user_group.admin_user_group_parent_id as admin_user_group_parent_id',
                'admin_user.is_frozen as admin_user_is_frozen',
                'admin_user_group.is_frozen as admin_user_group_is_frozen',
                'admin_user.created_at as admin_user_created_at',
                'admin_user.updated_at as admin_user_updated_at',
                'admin_user_group.updated_at as admin_user_group_created_at',
                'admin_user_group.updated_at as admin_user_group_updated_at'
            );
        //            ->whereRaw('`admin_user`.is_frozen = 0 and `admin_user_group`.is_frozen = 0');

        foreach ($credentials as $key => $value)
        {
            if (Str::contains($key, 'password'))
            {
                continue;
            }
            if (is_array($value) || $value instanceof Arrayable)
            {
                $adminUserModel->whereIn('admin_user.' . $key, $value);
            } else
            {
                $adminUserModel->where('admin_user.' . $key, $value);
            }
        }

        $adminUser = $adminUserModel->first();

        if ( ! isset($adminUser) || empty($adminUser))
        {
            return null;
        }
        $adminUser->makeVisible('password');
        $adminUser = $adminUser->toArray();
        $adminUserGroupMenuConfigRepository = new AdminUserGroupMenuConfigRepository();
        $allowAdminMenuIdListArr = $adminUserGroupMenuConfigRepository->getAdminMenuIdByAdminGroupId($adminUser['admin_user_group_id']);
        $allowAdminMenuIdList = [];
        if (count($allowAdminMenuIdListArr) > 1)
        {
            foreach ($allowAdminMenuIdListArr as $allowAdminMenuId)
            {
                $allowAdminMenuIdList[] = $allowAdminMenuId['admin_menu_id'];
            }
            $allowAdminMenuIdListString = implode(',', $allowAdminMenuIdList);

            $adminUser['admin_user_all_allow_admin_menu_id'] = $allowAdminMenuIdListString;

            $finalAdminUserAllowMenu = $this->addMainMenuPermission($allowAdminMenuIdList);
            $finalAdminUserAllowMenu = array_unique($finalAdminUserAllowMenu);
        } else
        {
            $adminUser['admin_user_all_allow_admin_menu_id'] = "";

        }
        $adminUser['admin_user_group'][0]['admin_user_group_id'] = $adminUser['admin_user_group_id'];
        $adminUser['admin_user_group'][0]['admin_user_group_name'] = $adminUser['admin_user_group_name'];
        $adminUser['admin_user_group'][0]['admin_user_group_parent_id'] = $adminUser['admin_user_group_parent_id'];
        $adminUser['admin_user_group'][0]['admin_user_group_is_frozen'] = $adminUser['admin_user_group_is_frozen'];

        unset($adminUser['admin_user_group_id'], $adminUser['admin_user_group_name'], $adminUser['admin_user_group_parent_id'], $adminUser['admin_user_group_is_frozen']);

        if ( ! isset($finalAdminUserAllowMenu) && empty($finalAdminUserAllowMenu))
        {
            $adminUser['admin_menu'] = [];
        } else
        {

            $adminMenuRepository = new AdminMenuRepository();
            $adminMenu = $adminMenuRepository->getAdminMenusByIdArray($finalAdminUserAllowMenu);
            if (count((array)$adminMenu) > 0)
            {
                $adminUser['admin_menu'] = infiniteTree($adminMenu, 0, 'admin_menu_parent_id', 'sub_menu');

                foreach ($adminMenu as $menu)
                {
                    //前端使用
                    $adminUser['admin_menu_array'][] = $menu['en_name'];

                    //後端使用
                    $adminUser['admin_menu_id'][] = $menu['id'];
                }

            }
        }

        if ($adminUser['admin_user_group'][0]['admin_user_group_id'] == 1)
        {
            $adminUser['role'] = 'super-admin'; //超管
        } else
        {
            if ( ! $adminUser['admin_user_group'][0]['admin_user_group_parent_id'])
            {
                $adminUser['role'] = 'admin';    //主管群
            } else
            {
                $adminUser['role'] = 'user';    //客服群
            }
        }

        //該登入者，可用的站點(廳主後台需要)
//        $adminUser = $this->appendSitePermission($adminUser);
        $adminUser = new AdminUser($adminUser);

        $adminUser->makeHidden('password');

        return $adminUser;
    }

    /**
     * @inheritDoc
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];

        return $this->hasher->check($plain, $user->getAuthPassword());
    }

    /**
     * @param null $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newModelQuery($model = null)
    {
        return is_null($model)
            ? $this->createModel()->newQuery()
            : $model->newQuery();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\' . ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * Get the first key from the credential array.
     *
     * @param array $credentials
     * @return string|null
     */
    protected function firstCredentialKey(array $credentials)
    {
        foreach ($credentials as $key => $value)
        {
            return $key;
        }
    }


    private function in_array_any($needles, $haystack)
    {
        return ! empty(array_intersect($needles, $haystack));
    }

    /**
     * @param array $finalAdminUserAllowMenu
     * @return array
     */
    private function addMainMenuPermission(array $finalAdminUserAllowMenu): array
    {
        if ($this->in_array_any([5, 13, 18, 24, 134, 143], $finalAdminUserAllowMenu))
        {
            //check system permission
            $finalAdminUserAllowMenu[] = 4;

        }

        if ($this->in_array_any([30, 33, 36, 39, 42, 45, 48, 145, 147, 149], $finalAdminUserAllowMenu))
        {
            //check report_analyze permission
            $finalAdminUserAllowMenu[] = 29;

        }

        if ($this->in_array_any([52, 59, 60, 65], $finalAdminUserAllowMenu))
        {
            //check telephone_admin permission
            $finalAdminUserAllowMenu[] = 51;

        }

        if ($this->in_array_any([69, 74, 151], $finalAdminUserAllowMenu))
        {
            //有以上權限，就傳短信管理的權限給前端去render menu
            $finalAdminUserAllowMenu[] = 68;

        }

        if ($this->in_array_any([80, 91, 99, 109, 118, 124], $finalAdminUserAllowMenu))
        {
            //check knowledge_admin permission
            $finalAdminUserAllowMenu[] = 79;

        }
        return $finalAdminUserAllowMenu;
    }

//    private function appendSitePermission(array $adminUser)
//    {
//        $adminUserGroupSiteConfigRepository = new AdminUserGroupSiteConfigRepository();
//        $availableSites = $adminUserGroupSiteConfigRepository->index(['admin_user_group_site_config.site_id'],
//            ['admin_user_group_id' => $adminUser['admin_user_group'][0]['admin_user_group_id']]
//        );
//
//        $adminUser['allow_site_id'] = array_map(function ($siteConfig) {
//            return $siteConfig['site_id'];
//        }, $availableSites['data']);
//
//        return $adminUser;
//
//    }
}

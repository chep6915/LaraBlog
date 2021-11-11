<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Enums\AdminUser\AdminUserEnablePasswordLoginType;
use App\Models\AdminUser;
use App\Services\AdminUserService;
use App\Services\IndexService;
use Illuminate\Support\Arr;

class IndexController extends BaseController
{

    /**
     * @var IndexService
     */
    private $indexService;
    /**
     * @var AdminUserService
     */
    private $adminUserService;

    public function __construct(
        IndexService     $indexService,
        AdminUserService $adminUserService
    )
    {
        $this->indexService = $indexService;
        $this->adminUserService = $adminUserService;
    }

    /**
     * @param $request
     * @return AdminUser
     */
    public function login($request): AdminUser
    {
        return $this->indexService->login($request);
    }

    /**
     * @param $googleUser
     * @return array
     */
    public function GoogleLogin($googleUser): array
    {
        $adminUserData = Arr::only($googleUser, ['name', 'email', 'avatar', 'avatar_original', 'nickname']);
        $adminUserData = array_merge($adminUserData, Arr::only($googleUser['user'], ['given_name', 'family_name', 'picture', 'locale']));
        $adminUserData['Google_id'] = $googleUser['user']['id'];
        $adminUserData['enable_password_login'] = AdminUserEnablePasswordLoginType::DisablePasswordLogin;

        $adminUser = $this->adminUserService->get([], ['email' => $adminUserData['email']]);

        if (!$adminUser['total']) {
            $adminUser = $this->adminUserService->store($adminUserData);
        }

        return $adminUser;
    }
}

<?php

namespace App\Repositories;

use App\Bases\BaseRepository;
use App\Classes\Redis\WlRedis;
use App\Models\AdminUser;
use App\Models\AdminUserGroup;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class AdminUserRepository extends BaseRepository
{
    /**
     * @param AdminUser $adminUser
     */
    public function __construct(AdminUser $adminUser)
    {
        $this->model = $adminUser;
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     * @return array
     */
    public function get(array $field = [], array $condition = [], array $orderBy = [], int $page = 0, int $pageLimit = 0): array
    {
        $query = $this->model->query();

        if (!empty($field)) {
            $query->select($field);
        } else {
            $query->selectRaw(
                "
                *
                "
            );
        }

        $condition = Arr::only(
            $condition, [
                'id',
                'account',
                'name',
                'admin_user_group_id',
                'email',
                'email_verified_at',
                'admin_user_last_ip',
                'last_update_admin_user_id',
                'is_frozen',
            ]
        );

        foreach ($condition as $key => $value) {
            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $val) {
                $query->orderBy($key, $val);
            }
        } else {
            $query->orderBy('id', 'ASC');
        }

        $queryForCount = clone $query;

        if ($pageLimit != 0) {
            $query->offset($page * $pageLimit);
            $query->limit($pageLimit);
        }

        $resultLength = $queryForCount->count();
        $resultList = $query->get()->toArray();

        return ['data' => $resultList, 'total' => $resultLength];
    }

//    /**
//     * @param $request
//     *
//     * @return JsonResponse
//     * Date: 2021/1/20 04:33:15
//     * Author: Rex
//     */
//    public function login($request): JsonResponse
//    {
//
//        $aum = model()->newModelQuery();
//
//        $aum->leftJoin('admin_user_group', 'admin_user.admin_user_group_id', '=', 'admin_user_group.id')
//            ->select
//            (
//                'admin_user.password',
//                'admin_user.id as admin_user_id',
//                'admin_user.name as admin_user_name',
//                'admin_user.account as admin_user_account',
//                'admin_user.email as admin_user_email',
//                'admin_user.admin_user_group_id as admin_user_group_id',
//                'admin_user_group.name as admin_user_group_name',
//                'admin_user_group.admin_user_group_parent_id as admin_user_group_parent_id',
//                'admin_user.enable as admin_user_enable',
//                'admin_user_group.enable as admin_user_group_enable',
//                'admin_user.created_at as admin_user_created_at',
//                'admin_user.updated_at as admin_user_updated_at',
//                'admin_user_group.updated_at as admin_user_group_created_at',
//                'admin_user_group.updated_at as admin_user_group_updated_at'
//            );
//
//        $aum->where('admin_user.account', $request['account']);
//
//        $au = $aum->first()->toArray();
//
//        $au['admin_user_group'][0]['admin_user_group_id'] = $au['admin_user_group_id'];
//        $au['admin_user_group'][0]['admin_user_group_name'] = $au['admin_user_group_name'];
//        $au['admin_user_group'][0]['admin_user_group_parent_id'] = $au['admin_user_group_parent_id'];
//        $au['admin_user_group'][0]['admin_user_group_enable'] = $au['admin_user_group_enable'];
//
//        unset($au['admin_user_group_id'], $au['admin_user_group_name'], $au['admin_user_group_parent_id'], $au['admin_user_group_enable']);
//
//        $au['last_ip'] = getUserIp();
//        $au = WlRedis::loginSetUser($au);
//
//        return ajaxReturn($au);
//        //SHOULD UPDATE LAST IP AND LAST LOGIN TINE HERE TODO LIST
//
//    }

    /**
     * @return JsonResponse
     * Date: 2021/1/20 04:42:59
     * Author: Rex
     */
    public function logout(): JsonResponse
    {
        return model()->logout();
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     * Date: 2021/1/20 04:47:14
     * Author: Rex
     */
    public function index($field = [], $condition = [], $orderBy = [], $page = 0, $pageLimit = 0): array
    {
        $query = $this->model->newQuery();

        $query->leftJoin('admin_user_group', 'admin_user.admin_user_group_id', '=', 'admin_user_group.id');
        $query->leftJoinSub(
            "
            SELECT id,account FROM admin_user
            ", 'au2', 'admin_user.last_update_admin_user_id', '=', 'au2.id'
        );

        if (!empty($field)) {
            $query->select($field);
        } else {
            $query->selectRaw(
                "
                admin_user.id,
                admin_user.account,
                admin_user.name,
                admin_user.email,
                admin_user.admin_user_group_id,
                admin_user_group.admin_user_group_parent_id,
                admin_user_group.name AS 'admin_user_group_name',
                admin_user.enable,
                admin_user.updated_at,
                au2.account AS 'last_update_admin_user_account'
                "
            );
        }

        $resultList = null;

        if (isset($condition['admin_user_id']) && !empty($condition['admin_user_id'])) {
            $query->where('admin_user.id', '=', $condition['admin_user_id']);
        }

        if (isset($condition['admin_user_account']) && !empty($condition['admin_user_account'])) {
            $query->where('admin_user.account', 'like', '%' . $condition['admin_user_account'] . '%');
        }

        if (isset($condition['admin_user_name']) && !empty($condition['admin_user_name'])) {
            $query->where('admin_user.name', 'like', '%' . $condition['admin_user_name'] . '%');
        }

        if (isset($condition['admin_user_group_parent_id']) && !empty($condition['admin_user_group_parent_id'])) {
            $query->where(function ($query) use ($condition) {
                $query->where('admin_user_group.admin_user_group_parent_id', '=', $condition['admin_user_group_parent_id']);
                $query->orWhere('admin_user_group.id', '=', $condition['admin_user_group_parent_id']);
            });
        }

        if (isset($condition['enable'])) {
            $query->where('admin_user.enable', '=', $condition['enable']);
        }

        $query->where('admin_user_group.enable', '=', 1);

        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $val) {
                $query->orderBy($key, $val);
            }
        } else {
            $query->orderBy('admin_user.id', 'asc');
        }

        $queryForCount = clone $query;

        if ($pageLimit != 0) {
            $query->offset($page * $pageLimit);
            $query->limit($pageLimit);
        }

        $resultLength = $queryForCount->count();
        $resultList = $query->get()->toArray();

        return ['data' => $resultList, 'length' => $resultLength];

    }

    /**
     * @param array $condition
     * @return mixed
     */
    public function deleteByCondition($condition = [])
    {
        $query = $this->adminUser->newQuery();

        foreach ($condition as $key => $value) {
            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->delete();
    }

    public function getAdminUserByMenuId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {
        $query = $this->adminUser->newQuery();

        $query->leftJoin('admin_user_group', 'admin_user_group.id', '=', 'admin_user.admin_user_group_id');
        $query->leftJoin('admin_user_group_menu_config', 'admin_user_group_menu_config.admin_user_group_id', '=',
            'admin_user_group.id');
        if (!empty($field)) {
            $query->select($field);
        } else {
            $query->select("admin_user.id", "admin_user.name");
        }

        $resultList = null;

        if (isset($condition['admin_menu_id']) && !empty($condition['admin_menu_id'])) {
            $query->where('admin_user_group_menu_config.admin_menu_id', '=', $condition['admin_menu_id']);
        }

        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $val) {
                $query->orderBy($key, $val);
            }
        } else {
            $query->orderBy('admin_user.id', 'asc');
        }

        $queryForCount = clone $query;

        if ($pageLimit != 0) {
            $query->offset($page * $pageLimit);
            $query->limit($pageLimit);
        }

        $resultLength = $queryForCount->count();
        $resultList = $query->get()->toArray();

        return ['data' => $resultList, 'length' => $resultLength];
    }

}


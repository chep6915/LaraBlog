<?php

namespace App\Services;

use App\Bases\BaseService;
use App\Classes\OperationRecord;
use App\Classes\Redis\WlRedis;
use App\Exceptions\JsException;
use App\Repositories\AdminUserGroupRepository;
use App\Repositories\AdminUserRepository;
use App\Repositories\OnlineExaminationRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class AdminUserService extends BaseService
{

    /**
     * @var AdminUserRepository
     */
    private $adminUserRepository;

    public function __construct(AdminUserRepository $adminUserRepository)
    {
        $this->adminUserRepository = $adminUserRepository;
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
        return $this->adminUserRepository->get($field, $condition, $orderBy, $page, $pageLimit);
    }

    /**
     * @param $data
     * @return array
     */
    public function store($data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $data['last_update_admin_user_id'] = isset(Auth::User()['admin_user_id']) ? Auth::User()['admin_user_id'] : 0;

        return $this->adminUserRepository->store($data);
    }

    /**
     * @param array $id
     *
     * @return bool
     * @throws Exception
     * Date: 2021/1/25 09:47:24
     * Author: Rex
     */
    public function destroy($id = []): bool
    {

        //验证有无带入超管id有则报错
        if (in_array(1, $id)) {
            throw new Exception('Can not delete super adminUser');
        }
        if (repository()->destroy($id)) {
//                (new OperationRecord([
//                    'id' => $id,
//                    'type' => 2,
//                    'function' => 'administrator_user_admin',
//                ]))->save();

            WlRedis::delTokenById($id);

            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $id
     * @param $data
     *
     * @return bool
     * Date: 2021/1/25 10:08:54
     * Author: Rex
     */
    public function update($id, $data): bool
    {

        //若将超管冻结回传失败
        if (isset($data['is_frozen']) && !empty($data['is_frozen'] && $id === 1)) {
            throw new JsException(['code' => 400]);
        }

        $data['last_update_admin_user_id'] = Auth::User()['admin_user_id'];

        if (repository()->update($id, $data)) {

//                (new OperationRecord(array_merge([
//                    'id' => $id,
//                    'type' => 1,
//                    'function' => 'administrator_user_admin',
//                ], Arr::only($data, ['name', 'admin_user_group_id', 'is_frozen', 'email']))))->save();

            WlRedis::delTokenById([$id]);

            return true;
        } else {
            return false;
        }

    }

    /**
     * @param array $condition
     *
     * @return bool
     * Date: 2021/1/18 20:11:30
     * Author: Rex
     */
    public function checkAdminUserExist($condition = []): bool
    {
        return repository()->getAdminUser([], $condition)['length'] >= 1;
    }

    /**
     * @param       $examinationPaperId
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    public function getCustomerServiceByExaminationPaperId($customerServiceList, $examinationPaperId)
    {

        $customerServiceData = $customerServiceList['data'];

        if ($customerServiceList['length'] > 0) {
            foreach ($customerServiceData as $customerServiceListIndex => $customerService) {

                $customerServiceData[$customerServiceListIndex]['status'] = $this->onlineExaminationRepository->getDataByAdminUserId($customerService['id'],
                    $examinationPaperId)['status'];
            }

        }

        return ['data' => $customerServiceData, 'length' => $customerServiceList['length']];

    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    //主管拿下层客服用
    public function getCustomerServiceBySelfAdminUserGroupId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {

        if (Auth::User()->isAdmin()) {
            //主管群搜索下层群组会员
            $condition['admin_user_group_id'] = Auth::User()->getCurrentAdminUserGroupId();
        } else {
            return ['data' => [], 'length' => 0];
        }

        return $this->adminUserRepository->getCustomerServiceByAdminUserGroupId($field, $condition, $orderBy, --$page,
            $pageLimit);
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    //主管拿下层客服用(包含已删除系统会员)
    public function getCustomerServiceWithTrashedBySelfAdminUserGroupId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {

        $condition['withTrashed'] = 1;
        return self::getCustomerServiceBySelfAdminUserGroupId($field, $condition, $orderBy, --$page,
            $pageLimit);
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    public function getAdminUserByMenuId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {
        return $this->adminUserRepository->getAdminUserByMenuId($field, $condition, $orderBy, --$page,
            $pageLimit);
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    //主管拿同层级主管及下层客服群组(包含已删除系统会员)
    public function getCustomerServiceAndManagerWithTrashedBySelfAdminUserGroupId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {

        $condition['withTrashed'] = 1;

        return self::getCustomerServiceAndManagerBySelfAdminUserGroupId($field, $condition, $orderBy, --$page,
            $pageLimit);
    }

    /**
     * @param array $field
     * @param array $condition
     * @param array $orderBy
     * @param int $page
     * @param int $pageLimit
     *
     * @return array
     */
    //主管拿同层级主管及下层客服群组
    public function getCustomerServiceAndManagerBySelfAdminUserGroupId(
        $field = [],
        $condition = [],
        $orderBy = [],
        $page = 0,
        $pageLimit = 0
    )
    {

        $condition['admin_user_group_id'] = Auth::User()->getCurrentAdminUserGroupId();

        return $this->adminUserRepository->getCustomerServiceAndManagerByAdminUserGroupId($field, $condition,
            $orderBy, $page,
            $pageLimit);
    }

}

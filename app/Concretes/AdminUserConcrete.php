<?php

namespace App\Concretes;

use App\Bases\BaseConcrete;
use App\Classes\OperationRecord;
use App\Enums\ResponseCode;
use App\Http\Controllers\Admin\AdminUserController;
use App\Services\AdminUserService;

class AdminUserConcrete extends BaseConcrete
{

    /**
     * @var AdminUserController
     */
    private $adminUserController;

    public function __construct(AdminUserController $adminUserController)
    {
        $this->adminUserController = $adminUserController;
    }

    public function get(array $field = [], array $condition = [], array $orderBy = [], int $page = 0, int $pageLimit = 0): array
    {
        return $this->adminUserController->get($field, $condition, $orderBy, $page, $pageLimit);
    }

    /**
     * @param $data
     * @return array
     */
    public function createOrGetAdminUser($data): array
    {
        $au = $this->adminUserController->get([], ['email' => $data['email']]);

        if (!$au['total']) {
            $au = $this->adminUserController->store($data);
        }

        return $au;
    }
}

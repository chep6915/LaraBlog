<?php

namespace App\Concretes;

use App\Bases\BaseConcrete;
use App\Classes\OperationRecord;
use App\Services\AdminUserService;

class AdminUserConcrete extends BaseConcrete
{

    /**
     * @var AdminUserService
     */
    private $adminUserService;

    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
    }

    public function get($field = [], $condition = [], $orderBy = [], $page = 0, $pageLimit = 0)
    {
        return $this->adminUserService->get($field = [], $condition = [], $orderBy = [], $page = 0, $pageLimit = 0);
    }

}

<?php

namespace App\Concretes;

use App\Bases\BaseConcrete;
use App\Http\Controllers\Admin\AdminUserController;

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

}

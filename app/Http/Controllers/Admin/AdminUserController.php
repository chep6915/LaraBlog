<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Models\AdminUser;
use App\Services\AdminUserService;
use Illuminate\Http\Request;

class AdminUserController extends BaseController
{
    /**
     * @var AdminUserService
     */
    private $adminUserService;

    /**
     * @param AdminUserService $adminUserService
     */
    public function __construct(AdminUserService $adminUserService)
    {
        $this->adminUserService = $adminUserService;
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
        return $this->adminUserService->get($field, $condition, $orderBy, $page, $pageLimit);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param $data
     * @return array
     */
    public function store($data): array
    {
        return $this->adminUserService->store($data);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\AdminUser $adminUser
     * @return \Illuminate\Http\Response
     */
    public function show(AdminUser $adminUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\AdminUser $adminUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminUser $adminUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\AdminUser $adminUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdminUser $adminUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\AdminUser $adminUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminUser $adminUser)
    {
        //
    }
}

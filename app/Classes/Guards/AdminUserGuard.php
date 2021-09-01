<?php


namespace App\Classes\Guards;

use App\Classes\Redis\XRedis;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Traits\Macroable;

class AdminUserGuard
{
    use GuardHelpers, Macroable;

    /**
     * @inheritDoc
     */
    public function guest()
    {
        // TODO: Implement guest() method.
    }

    /**
     * @param Request $request
     *
     * @return AdminUser|null
     * Date: 2021/1/25 06:15:29
     * Author: Rex
     */
    public function user(Request $request): ?AdminUser
    {

        $adminUser = XRedis::getUserFromRedis($request->bearerToken());

        if ($adminUser) {
            return new AdminUser($adminUser);
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        // TODO: Implement id() method.
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     */
    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }

    /**
     * @inheritDoc
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        // TODO: Implement attempt() method.
    }

    /**
     * @inheritDoc
     */
    public function once(array $credentials = [])
    {
        // TODO: Implement once() method.
    }

    /**
     * @inheritDoc
     */
    public function login(Authenticatable $user, $remember = false)
    {
        // TODO: Implement login() method.
    }

    /**
     * @inheritDoc
     */
    public function loginUsingId($id, $remember = false)
    {
        // TODO: Implement loginUsingId() method.
    }

    /**
     * @inheritDoc
     */
    public function onceUsingId($id)
    {
        // TODO: Implement onceUsingId() method.
    }

    /**
     * @inheritDoc
     */
    public function viaRemember()
    {
        // TODO: Implement viaRemember() method.
    }


}

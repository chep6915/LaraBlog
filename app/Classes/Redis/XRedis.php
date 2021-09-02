<?php

namespace App\Classes\Redis;

use App\Models\AdminUser;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;

class XRedis extends Redis
{

    /**
     * @param AdminUser $adminUser
     * @return AdminUser
     */
    public static function loginSetUser(AdminUser $adminUser): AdminUser
    {

        $userToken = strtotime(now()) . $adminUser['admin_user_id'];

        if (!empty(env('MULTIPLE_LOGIN')) && env('MULTIPLE_LOGIN') == 1) {
            $redisToken = $adminUser['admin_user_id'] . '_' . strtotime(now());
        } else {
            $redisToken = $adminUser['admin_user_id'];
        }

        $adminUser['token'] = md5($adminUser['admin_user_id'] . strtotime(now())) . '#' . base64_encode($userToken);
//        parent::setex($redisToken,config('app.redis_timeout'),serialize($adminUser));
        parent::setex($redisToken,6000,serialize($adminUser));

        return $adminUser;
    }

    /**
     * @param $token
     * @return bool
     */
    public static function checkUserExistInRedis($token)
    {
//        $adminUserip = self::getUserIp();
//
//        $adminUser['id'] = hexdec(explode('#', $token)[1]);
//
//        $redisData = unserialize(parent::get($adminUser['id']));
//
//        if ($redisData && $adminUserip == $redisData['lastip']) {
//
//            self::extendTTL($adminUser['id']);
//            return true;
//        } else {
//            return false;
//        }
    }

    /**
     * @return mixed
     * Date            2021/1/5 16:57:29
     * Author          Rex
     */
    public static function logoutDeleteUser()
    {

        $token = Request::bearerToken();

        $redisToken = base64_decode(explode('#', $token)[1]);

        if (!empty(env('MULTIPLE_LOGIN')) && env('MULTIPLE_LOGIN') == 1) {
            $redisToken = substr($redisToken, 10) . '_' . substr($redisToken, 0, 10);
        } else {
            $redisToken = substr($redisToken, 10);
        }

        return parent::del($redisToken);
    }

    /**
     * @param $token
     * @return mixed
     */
    public static function getUserFromRedis($token)
    {
//        $adminUserIP = getUserIp();
        $adminUserIP = '127.0.0.1';

        if (!isset(explode('#', $token)[1])) {
            return false;
        }

        $redisToken = base64_decode(explode('#', $token)[1]);

        if (!empty(env('MULTIPLE_LOGIN')) && env('MULTIPLE_LOGIN') == 1) {
            $redisToken = substr($redisToken, 10) . '_' . substr($redisToken, 0, 10);
        } else {
            $redisToken = substr($redisToken, 10);
        }

        $redisData = unserialize(parent::get($redisToken));

        if ($redisData && $token === $redisData['token']) {
            //无法多登
            if (!empty(env('MULTIPLE_LOGIN')) && env('MULTIPLE_LOGIN') != 1) {
                if ($adminUserIP !== $redisData['lastip']) {
                    return false;
                }
                self::extendTTL($redisData['admin_user_id']);
            }
            self::extendTTL($redisToken);
            return $redisData;
        }
        return false;
    }

    /**
     * @param $userId
     */
    public static function extendTTL($userId)
    {
        parent::expire($userId, env('REDIS_TIMEOUT'));
    }


    /**
     * @param array $userId
     */
    public static function delTokenById($userId = array())
    {
        if (!empty($userId)) {
            //无法多登
            if (!empty(env('MULTIPLE_LOGIN')) && env('MULTIPLE_LOGIN') == 1) {
                $allKey = parent::keys('*');
                foreach ($allKey as $key => $val) {
                    $key = explode('_', $val)[1];
                    if (in_array($key, $userId)) {
                        parent::del(str_replace(explode('_', $val)[0] . '_', '', $val));
                    }
                }
            } else {
                foreach ($userId as $key => $val) {
                    parent::del($val);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public static function deleteAll()
    {
        $allKey = parent::keys('*');
        foreach ($allKey as $key => $val) {
            $key = explode('_', $val)[0];
            if ($key . '_' === env('REDIS_PREFIX')) {
                parent::del(str_replace(env('REDIS_PREFIX'), '', $val));
            }

        }
    }
}

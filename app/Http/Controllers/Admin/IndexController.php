<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Concretes\AdminUserConcrete;
use App\Concretes\IndexConcrete;
use App\Exceptions\JsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function PHPUnit\Framework\exactly;

class IndexController extends BaseController
{

    /**
     * @var IndexConcrete
     */
    private $indexConcrete;

    public function __construct(Request $request, IndexConcrete $indexConcrete)
    {
        $this->indexConcrete = $indexConcrete;
        parent::__construct($request);
    }

    public function login(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->indexConcrete->login($this->request)]);
    }

    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleProviderCallback()
    {
        try {
            $au = Socialite::driver('google')->stateless()->user();
            if (isset($au)) {
                $au = array($au);
                $auConcrete = new AdminUserConcrete();
//                $au = $auConcrete->get([],['email'=>$au['user']['email']]);
            }

            echo json_encode($au);
            exit();
//            [token] => ya29.a0ARrdaM8_40cuNCsFQsLIdELKqThCyVNVdIHBo6sCjqViimwnV3jmvNr_fgtyxDKnZleTm4mkTIvYotuZGev3hUsC0G90djKmjYgrHPgeR0yc79owYJK3NQSfwTkaE9OwstdTp_PqBEnqjFjpSh0QXjuBcn2b
//            [refreshToken] =>
//            [expiresIn] => 3599
//            [id] => 106195008024509355308
//            [nickname] =>
//            [name] => 謝佳良
//            [email] => chep6915@gmail.com
//            [avatar] => https://lh3.googleusercontent.com/a/AATXAJzR5ujUqAAOrDsrQ8zWOQ691dhkQbh2Wyk6z8lD=s96-c
//            [user] => Array (
//                [sub] => 106195008024509355308
//                [name] => 謝佳良
//                [given_name] => 佳良
//                [family_name] => 謝
//                [picture] => https://lh3.googleusercontent.com/a/AATXAJzR5ujUqAAOrDsrQ8zWOQ691dhkQbh2Wyk6z8lD=s96-c
//                [email] => chep6915@gmail.com
//                [email_verified] => 1
//                [locale] => zh-TW
//                [id] => 106195008024509355308
//                [verified_email] => 1
//                [link] =>
//            )
//                [avatar_original] => https://lh3.googleusercontent.com/a/AATXAJzR5ujUqAAOrDsrQ8zWOQ691dhkQbh2Wyk6z8lD=s96-c

        } catch (\Exception $e) {
            echo $e;
            exit();
        }
    }
}

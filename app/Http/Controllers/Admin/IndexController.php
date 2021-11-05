<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Concretes\AdminUserConcrete;
use App\Concretes\IndexConcrete;
use App\Enums\ResponseCode;
use App\Exceptions\JsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return response()->json(
            [
                'code' => ResponseCode::Success,
                'data' => [$this->indexConcrete->login($this->request)],
                'total' => 1
            ]
        );
    }

    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();

    }

    public function handleProviderCallback()
    {

        $gUser = Socialite::driver('google')->stateless()->user();
        $gUser = json_decode(json_encode($gUser), true);

        $au = $this->indexConcrete->GoogleLogin($gUser);

        return response()->json(
            [
                'code' => ResponseCode::Success,
                'data' => $au['data'],
                'total' => $au['total']
            ]
        );
    }
}

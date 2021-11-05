<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Concretes\IndexConcrete;
use App\Enums\ResponseCode;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @return RedirectResponse
     */
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()->redirect();

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleProviderCallback(): \Illuminate\Http\JsonResponse
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

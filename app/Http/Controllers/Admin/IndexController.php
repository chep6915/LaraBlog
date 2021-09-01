<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Redis\XRedis;
use App\Exceptions\JsException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function login()
    {

        Auth::attempt(['account' => $this->request['account'], 'password' => $this->request['password']]);

        echo '成功登入';exit();

    }

}

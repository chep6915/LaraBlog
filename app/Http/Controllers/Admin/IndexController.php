<?php

namespace App\Http\Controllers\Admin;

use App\Bases\BaseController;
use App\Concretes\IndexConcrete;
use App\Exceptions\JsException;
use Illuminate\Http\Request;

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

    public function login()
    {
        return response()->json(['data'=> $this->indexConcrete->login($this->request)]);

    }

}

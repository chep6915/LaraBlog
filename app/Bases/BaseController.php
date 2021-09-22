<?php

namespace App\Bases;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;

class BaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $request;

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __construct(Request $request)
    {
        if (PHP_SAPI != "cli")
            $this->validateRequest($request);
    }

//    public function validate(Request $request, array $rules,
//                             array $messages = [], array $customAttributes = [])
//    {
//        return $this->getValidationFactory()->make(
//            $request->all(), $rules, $messages, $customAttributes
//        )->validate();
//    }

    /**
     * @param Request $request
     * @param string $name
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRequest(Request $request, string $name = '')
    {

        if (!$validator = $this->getValidator($request, $name)) {
            return;
        }

        $rules = Arr::get($validator, 'rules', []);
        $messages = Arr::get($validator, 'messages', []);
        $codes = Arr::get($validator, 'codes', []);
        $params = Arr::get($validator, 'params', []);
        $this->validate($request, $rules, $messages,$codes);

        $this->request = (isset($params) && !empty($params)) ? $request->only($params) : $request->all();
    }

    /**
     * @param Request $request
     * @param string $name
     * @return false|mixed|void
     */
    protected function getValidator(Request $request, string $name = '')
    {

        if ($request->route() == null) {
            return;
        }
        list($controller, $method) = explode('@', $request->route()->action['uses']);

        $method = $name ?: $method;

        $class = str_replace('Controller', 'Request', $controller);

        if (!class_exists($class) || !method_exists($class, $method)) {
            return false;
        }

        return call_user_func([new $class, $method]);
    }

}

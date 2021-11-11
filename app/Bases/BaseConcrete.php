<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/15 0015
 * Time: 14:33
 */

namespace App\Bases;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class BaseConcrete extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var array
     */
    protected $request;

    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function __construct(Request $request)
    {
        if (PHP_SAPI != "cli")
            $this->validateRequest($request);
    }

    /**
     * @param Request $request
     * @param string $name
     * @throws ValidationException
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

        $class = str_replace('Concrete', 'Request', $controller);

        if (!class_exists($class) || !method_exists($class, $method)) {
            return false;
        }

        return call_user_func([new $class, $method]);
    }

    /**
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return array
     * @throws ValidationException
     */
    public function validate(Request $request, array $rules,
                             array $messages = [], array $customAttributes = [])
    {
        $validator = $this->getValidationFactory()->make(
            $request->all(), $rules, $messages, $customAttributes
        );

        if ($validator->fails())
        {
//            \Illuminate\Validation\Validator::class
//            echo get_class($validator);exit();
//            echo json_encode($validator);exit();
//            $this->throwValidationException($request, $validator);
        }

//        return $this->getValidationFactory()->make(
//            $request->all(), $rules, $messages, $customAttributes
//        )->validate();
    }
}
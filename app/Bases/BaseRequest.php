<?php

namespace App\Bases;

use App\Exceptions\JsException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Date: 2021/1/15 22:54:15
 * Author: Rex
 */
class BaseRequest extends FormRequest
{

    /**
     * @param Validator $validator
     * Date: 2021/1/15 22:54:21
     * Author: Rex
     */
    protected function failedValidation(Validator $validator)
    {
        $rs = ['code' => 100];

        if (config('app.debug')) {
            $rs = array_merge($rs, ['message' => $validator->getMessageBag()->first()]);
        }

        throw new JsException($rs);
    }

    /**
     * @return array
     * Date            2021/1/15 17:54:05
     * Author          Rex
     */
    public function rules(): array
    {
        if (!isset(debug_backtrace()[18]['args'][1]->name) || empty(debug_backtrace()[18]['args'][1]->name)) {
            throw new JsException(['code' => 110]);
        }

        try {
            $validate = $this->container->call([$this, debug_backtrace()[18]['args'][1]->name]);

            return (isset($validate['rule']) && !empty($validate['rule'])) ? $validate['rule'] : [];

        } catch (\Exception $e) {
            throw new JsException(['code' => 111]);
        }
    }

    /**
     * @return array
     * Date            2021/1/15 21:14:45
     * Author          Rex
     */
    public function messages(): array
    {

        if (!isset(debug_backtrace()[13]['args'][1]->name) || empty(debug_backtrace()[13]['args'][1]->name)) {
            throw new JsException(['code' => 110]);
        }

        try {
            $validate = $this->container->call([$this, debug_backtrace()[13]['args'][1]->name]);

            return (isset($validate['message']) && !empty($validate['message'])) ? $validate['message'] : [];

        } catch (\Exception $e) {
            throw new JsException(['code' => 111]);
        }
    }

}

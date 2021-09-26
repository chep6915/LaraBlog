<?php

namespace App\Http\Requests\Admin;

use App\Bases\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class IndexRequest extends BaseRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    public function login(): array
    {
        return [
            'rules' => [
                'email' => 'required|string|max:20',
                'password' => 'required|min:6|max:30',
            ],
            'messages' => [
            ],
            'codes' => [
                'email.required' => '132'
            ],
            'params' => [
                'email',
                'password'
            ]
        ];
    }

    public function index(): array
    {
        return [
            'rule' => [
                'page' => 'integer|min:1',
                'page_limit' => 'integer|min:1',
                'sort_column' => 'string',
                'direction' => 'in:1,-1',
            ]
        ];
    }

    public function store(): array
    {
        return [
            'rule' => [
                'name' => 'required|string|max:20',
                'account' => 'required|alpha_num|max:20',
                'email' => ['required', 'email'],
                'password' => 'required|min:6|max:30',
                'c_password' => 'required|same:password',
                'admin_user_group_id' => 'required|integer',
                'enable' => 'integer',
            ],
            'message' => [
            ]
        ];
    }

    public function update(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'string|max:20', //名称
            'admin_user_group_id' => 'integer',
            'enable' => 'integer',   //是否启用
            'email' => ['email'], //邮箱
            'password' => 'min:6|max:30',
            'c_password' => 'same:password',
        ];

    }

    public function destroy(): array
    {
        return [
            'rule' => [
                'id' => 'required|array|min:1',
            ]
        ];
    }
}

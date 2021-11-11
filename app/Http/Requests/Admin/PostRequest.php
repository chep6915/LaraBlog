<?php

namespace App\Http\Requests\Admin;

use App\Bases\BaseRequest;

class PostRequest extends BaseRequest
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

    public function store(): array
    {
        return [
            'rules' => [
                'category_id' => 'required|integer',
                'title' => 'required|string|max:20',
                'sub_title' => 'required|string|max:20',
                'tag_id' => 'required|integer',
                'content' => 'required|string|max:20',
                'publish_date' => 'date_format:Y-m-d',
                'public_type' => 'required|integer',
                'reply_type' => 'required|integer',
                'is_top' => 'required|integer',
                'sync_publish_id' => 'required|integer',
                'status' => 'required|integer'
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

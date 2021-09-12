<?php

namespace App\Exceptions;

use App\Bases\BaseException;

class JsException extends BaseException
{

    /**
     * JsException constructor.
     *
     * @param array $data
     * @param int   $status
     * @param array $headers
     * @param int $options
     */
    public function __construct($data = [], $status = 200, $headers = [], int $options = 0)
    {
        parent::__construct(response()->json($data, $status, $headers, $options));
    }
}

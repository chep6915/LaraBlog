<?php

namespace App\Bases;

use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class BaseException extends HttpResponseException
{

    public function __construct(Response $response)
    {
        parent::__construct($response);
    }

}

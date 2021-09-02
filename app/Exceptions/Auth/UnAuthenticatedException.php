<?php

namespace App\Exceptions\Auth;

use App\Enums\ResponseCode;
use App\Exceptions\Http\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Unauthenticated Exception
 *
 * @package App\Exceptions\Http
 */
class UnAuthenticatedException extends HttpException
{
    /**
     * An HTTP status code.
     *
     * @var int
     */
    protected $status = 200;

    /**
     * The error code.
     *
     * @var string|null
     */
    protected $errorCode = ResponseCode::UnAuthenticatedError;
}

<?php

namespace App\Exceptions;

use App\Enums\ResponseCode;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param Request $request
     * @param Throwable $e
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {

        if ($request->expectsJson()) {

            if ($e instanceof AuthenticationException)
                return response()->json([
                    'code' => ResponseCode::UnAuthenticatedError,
                    'data' => [],
                    'total' => 0
                ], 401);

            if ($e instanceof ValidationException) {
                $data = [
                    'code' => ResponseCode::ValidationFailedError,
                    'data' => [],
                    'total' => 0
                ];

                if (config('app.debug')) {
                    $data['msg'] = $e->getMessage();
                    $data['error'] = $e->errors();
                }

                return response()->json($data, 422);
            }

//            return config('app.debug') ? [
//                'message' => $e->getMessage(),
//                'exception' => get_class($e),
//                'file' => $e->getFile(),
//                'line' => $e->getLine(),
//                'trace' => collect($e->getTrace())->map(function ($trace) {
//                    return Arr::except($trace, ['args']);
//                })->all(),
//            ] : [
//                'message' => $this->isHttpException($e) ? $e->getMessage() : 'Server Error',
//            ];

            if ($e instanceof JsException)
                return $e->getResponse();
        } else {
            return parent::render($request, new NotFoundHttpException());
        }

        log::info('exception generate');
        log::error(json_encode($e));
        //Validate驗證錯誤ValidationException
        return parent::render($request, $e);
    }

}

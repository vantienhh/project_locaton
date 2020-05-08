<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->expectsJson()) {
            $success = false;
            $response = null;
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            if ($e instanceof HttpResponseException) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $response = $e->getResponse();
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                $status = Response::HTTP_METHOD_NOT_ALLOWED;
                $e = new MethodNotAllowedHttpException([], 'HTTP_METHOD_NOT_ALLOWED', $e);
            } elseif ($e instanceof NotFoundHttpException) {
                $status = Response::HTTP_NOT_FOUND;
                $e = new NotFoundHttpException('HTTP_NOT_FOUND', $e);
            } elseif ($e instanceof AuthorizationException) {
                $status = Response::HTTP_FORBIDDEN;
                $e = new AuthorizationException('HTTP_FORBIDDEN', $status);
            } elseif ($e instanceof AuthenticationException) {
                $status = Response::HTTP_UNAUTHORIZED;
                $e = new HttpException($status, 'HTTP_UNAUTHORIZED');
            } elseif ($e instanceof \Dotenv\Exception\ValidationException && $e->getResponse()) {
                $status = Response::HTTP_BAD_REQUEST;
                $e = new \Dotenv\Exception\ValidationException('HTTP_BAD_REQUEST', $status, $e);
                $response = $e->getResponse();
            } elseif ($e) {
                $e = new HttpException($status, 'HTTP_INTERNAL_SERVER_ERROR');
            }
            return response()->json([
                'success' => $success,
                'status' => $status,
                'message' => $e->getMessage()
            ], $status, [
                'Access-Control-Allow-Origin'      => '*',
                'Access-Control-Allow-Methods'     => '*',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Max-Age'           => '86400',
                'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With'
            ]);
        }
        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => $exception->getMessage()], 401);
//        return $request->expectsJson()
//            ? response()->json(['message' => $exception->getMessage()], 401)
//            : redirect()->guest($exception->redirectTo() ?? route('login'));
    }
}

<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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

    public function render($request, Throwable $e)
    {
        $err = responder()->setData(null);

        switch (true) {
            case $e instanceof ModelNotFoundException:
            case $e instanceof NotFoundHttpException:
            case $e instanceof RouteNotFoundException:
                return $err->setCode(Response::HTTP_NOT_FOUND)
                    ->setMsg('Not found.')
                    ->get();
            case $e instanceof AuthenticationException:
                return $err
                    ->setCode(Response::HTTP_UNAUTHORIZED)
                    ->setMsg($e->getMessage())
                    ->get();
            case $e instanceof AuthorizationException:
                return $err->setCode(Response::HTTP_FORBIDDEN)
                    ->setMsg('This action is unauthorized.')
                    ->get();
            case $e instanceof ValidationException:
                return $err
                    ->setMsg($e->getMessage())
                    ->setData($e->errors())
                    ->setCode(Response::HTTP_UNPROCESSABLE_ENTITY)
                    ->get();
            case $e instanceof MethodNotAllowedHttpException:
                return $err
                    ->setCode($e->getStatusCode())
                    ->setMsg($e->getMessage())
                    ->get();
            default:
                return $err
                    ->setData(['exception' => get_class($e)])
                    ->setMsg('Something went wrong.')
                    ->get();
        }
    }
}

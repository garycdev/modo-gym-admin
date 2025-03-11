<?php
namespace App\Exceptions;

// use Illuminate\Auth\AuthenticationException;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // if ($exception instanceof AuthenticationException) {
        //     // Si la solicitud espera un JSON, devolver una respuesta JSON
        //     if ($request->wantsJson()) {
        //         return response()->json(['message' => 'No autorizado. Token inválido o no proporcionado.'], 401);
        //     }
        // }
        
        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return response()->view('errors.403', [], 403);
        }
        return parent::render($request, $exception);
    }

    // protected function unauthenticated($request, AuthenticationException $exception): JsonResponse
    // {
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'No autorizado. Token no válido o no proporcionado.',
    //     ], 401);
    // }
}

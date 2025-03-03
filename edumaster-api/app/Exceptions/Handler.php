<?php

namespace App\Exceptions;

use Edumaster\Shared\Domain\Exception\DomainException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
  // ...

  /**
   * Handle unauthenticated user exception.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Illuminate\Auth\AuthenticationException  $exception
   * @return \Symfony\Component\HttpFoundation\Response
   */
  protected function unauthenticated($request, AuthenticationException $exception)
  {
    // Verifica si la solicitud espera una respuesta JSON
    if ($request->expectsJson()) {
      return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Redirige a la ruta de login por defecto
    return redirect()->guest(route('login'));
  }


  public function render($request, Throwable $exception): JsonResponse
  {
    if ($exception instanceof DomainException) {
      return response()->json([
        'code' => $exception->errorCode(),
        'message' => $exception->getMessage(),
      ], $exception->getCode());
    }

    return parent::render($request, $exception);
  }
}

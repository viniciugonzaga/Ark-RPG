<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
   public function render($request, Throwable $exception)
{
    if ($exception instanceof TokenMismatchException) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Sessão expirada. Recarregue a página.'], 419);
        }
        return response()->view('errors.419', [], 419);
    }

    return parent::render($request, $exception);
}
}
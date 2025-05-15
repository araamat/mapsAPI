<?php

namespace App\Exceptions;

use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            // ✅ Teavitus Inertia jaoks
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                return back()->with('error', 'Your session expired. Please try again.');
            }

            // ✅ Fallback
            return redirect()->back()->with('error', 'Your session expired. Please try again.');
        }

        return parent::render($request, $exception);
    }
}

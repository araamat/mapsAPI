<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException && $exception->getStatusCode() === 419) {
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                return back()->with([
                    'error' => 'Your session expired. Please try again.',
                ]);
            }

            return redirect()->back()->with('error', 'Your session expired. Please try again.');
        }

        return parent::render($request, $exception);
    }
}

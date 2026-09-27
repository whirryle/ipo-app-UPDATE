<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * Override untuk memastikan error detail tidak bocor ke user
     */
    public function render($request, Throwable $e)
    {
        // Log error detail untuk debugging (hanya di server log)
        Log::error('Exception caught in Handler', [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'ip' => $request->ip(),
            'user_id' => auth()->id() ?? null,
        ]);

        // Jika request expect JSON (API call)
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada server. Silakan coba lagi nanti.',
                'error' => config('app.debug') ? $e->getMessage() : null, // hanya tampil jika debug mode
            ], 500);
        }

        // Untuk request web biasa, tampilkan halaman error generik
        if ($this->isHttpException($e)) {
            // HTTP exceptions (404, 403, dll) tetap di-handle normal
            return parent::render($request, $e);
        }

        // Semua exception lain: redirect back dengan pesan error generik
        return redirect()->back()
            ->withInput($request->except(['password', 'password_confirmation', 'current_password']))
            ->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi nanti.']);
    }
}

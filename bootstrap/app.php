<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if ($request->is('api/v1/auth/logout')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login dulu baru logout, kocak!.',
                ], 401);
            }
        });
        
        // error belum login
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sesi Anda telah berakhir atau token tidak valid. Silakan login kembali.',
                ], 401);
            }
        });


        //error 404 not found & data tidak ada
        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if ($request->is('api/*')) {

                $message = 'Endpoint API tidak ditemukan.';

                // Jika error aslinya karena Model tidak ketemu (findOrFail)
                if ($exception->getPrevious() instanceof ModelNotFoundException) {
                    // Ambil nama modelnya, contoh: App\Models\User menjadi 'User'
                    $modelName = class_basename($exception->getPrevious()->getModel());
                    $message = "Data {$modelName} tidak ditemukan di database.";
                }

                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 404);
            }
        });

        $exceptions->render(function (AccessDeniedHttpException $exception, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda tidak memiliki izin, hanya admin yang memiliki izin.',
                ], 403);
            }
        });

    })->create();

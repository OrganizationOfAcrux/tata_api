<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('success', function ($data, $msg) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'msg' => $msg,
            ], 200);
        });

        Response::macro('error', function ($msg, $status_code) {
            return response()->json([
                'success' => false,
                'msg' => $msg,
            ], $status_code);
        });
    }
}

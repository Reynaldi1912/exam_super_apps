<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tidak perlu melakukan apa-apa di sini
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menyiapkan variabel default
        $userData = 0;
        $appData = -1;

        // Mendapatkan session user_id
        // $url = 'http://localhost:7000';
        $url = 'http://192.168.10.167:7000';
        $websocket = 'http://192.168.10.167:8080';
      

        // Menyimpan konfigurasi yang dibutuhkan
        config([
            'app.url' => $url,
            'app.websocket' => $websocket
        ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.nav', function ($view) {
            $playerInfo = $this->getPlayerInformation();
            $view->with('playerInfo', $playerInfo);
        });
    }

    private function getPlayerInformation()
    {
        $playerInfoId = session('PlayerInfo_ID');
        $response = Http::get('http://127.0.0.1:8000/api/players/' . $playerInfoId);
        if ($response->successful()) {
            return $response->json();
        } else {
            return null;
        }
    }
}

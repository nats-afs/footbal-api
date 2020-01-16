<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $baseUrl = env('API_ENDPOINT');
        // $this->app->singleton(Client::class, function($app) use ($baseUrl) {
        //     return new Client(
        //         [
        //             'base_uri' => $baseUrl,
        //             'defaults' => [
        //                 'verify' => false,
        //                 'headers' => ['X-Auth-Token'  =>  ['ab794dbbc14b4e919c16d7747ff03140']]
        //             ]
        //         ]);
        // });
    
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

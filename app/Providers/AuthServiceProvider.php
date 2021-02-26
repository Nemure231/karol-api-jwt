<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     return app('auth')->setRequest($request)->user();
        // });

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     //awalnya header ini input, tapi dirubah jadi header karena masukin api tokennya harus di header postman
        //     ///lalu Authorization tadinya api_token
        //     if ($request->header('Authorization')) {
        //         //explode digunakan untuk memotong bagian kosong pada vaule di header postman
        //         //proses explode juga akan mengubahnya menjadi type data array
        //         $api_token = explode(' ', $request->header('Authorization'));
        //         ///index 1 diberikan karena index 0 adalah index parent merupakan 0, dan index 1 adalah index yang terdapat datanya
        //         return User::where('api_token', $api_token[0])->first();
        //     }
        // });
    }
}

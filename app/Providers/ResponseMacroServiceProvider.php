<?php
/**
 * Created by PhpStorm.
 * User: chukui
 * Date: 2018/11/25
 * Time: 13:35
 */

namespace App\Providers;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data=[], $message="", $code=200) {
            return Response::json([
                "code" => $code,
                "message" => $message,
                "data" => $data,
            ]);
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
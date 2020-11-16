<?php

namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //成功
        Response::macro('success',function ($message = 'success',$data = []){
            return Response::json([
                'code' => 200,
                'message' => $message,
                'data' => $data,
                'time' => date('Y-m-d H:i:s')
                ]);
        });
        //错误
        Response::macro('error',function ($message = 'error',$data = []){
            return Response::json([
                'code' => 90001,
                'message' => $message,
                'data' => $data,
                'time' => date('Y-m-d H:i:s')
                ]);
        });
    }
}

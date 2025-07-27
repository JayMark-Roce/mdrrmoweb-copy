<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
=======
use Illuminate\Support\Facades\URL;
>>>>>>> 887899e7221396f620d0d6dad872e632d494197b

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
<<<<<<< HEAD
        //
=======
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
>>>>>>> 887899e7221396f620d0d6dad872e632d494197b
    }
}

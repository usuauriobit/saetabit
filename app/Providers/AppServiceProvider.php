<?php

namespace App\Providers;

use App\Services\TasaCambioService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind('path.public', function() { return base_path('../../../public_html'); });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        setlocale(LC_ALL, 'es_MX', 'es', 'ES', 'es_MX.utf8');

        Blade::directive('soles', function ($money) {
            return "<?php echo 'S/ '.number_format( (round($money,2)), 2, '.', ','); ?>";
        });
        Blade::directive('dolares', function ($money) {
            return "<?php echo '$ '.number_format( (round($money,2)), 2, '.', ','); ?>";
            if(is_numeric($money)){
            }else{
                return "<?php echo '-'; ?>";
            }
        });
        Blade::directive('toDolares', function ($money) {
            $dolares = (new TasaCambioService())->getMontoDolares($money);
            return "<?php echo '$ '.number_format( (round($dolares,2)), 2, '.', ','); ?>";
            if(is_numeric($money)){
            }else{
                return "<?php echo '-'; ?>";
            }
        });
        Blade::directive('toSoles', function ($money) {
            return
            "<?php
                echo 'S/ '.number_format( (round(
                    (new \App\Services\TasaCambioService())->getMontoSoles($money)
                    ,2)), 2, '.', ',');
            ?>";
        });
        Blade::directive('nro', function ($number) {
            return "<?php echo number_format( (round($number,2)), 2, '.', ','); ?>";
            if(is_numeric($number)){
            }else{
                return "<?php echo '-'; ?>";
            }
        });
        Blade::directive('toneladas', function ($number) {
            return "<?php echo number_format( (round($number,2)/1000), 2, '.', ','); ?>";
        });
    }
}

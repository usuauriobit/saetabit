<?php

namespace App\Console;

use App\Models\Pasaje;
use App\Schedule\DeletePasajesSinPagar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**eliminar
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        // $schedule->call(function () {
        //     \Log::debug('Test var fails');
        //     Pasaje::first()
        //     // ::whereDate('created_at', '<=', $dos_horas_antes)
        //     // ->whereHas('venta_detalle', function ($q){
        //     //     $q->whereHas('venta', function ($q){
        //     //         $q->doesntHave('caja_movimientos');
        //     //     });
        //     // })
        //     ->delete();
        // })->everyMinute();
        $schedule->call(new DeletePasajesSinPagar)->everyMinute();
        // $schedule->command()->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

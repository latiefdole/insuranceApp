<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Pagination\Paginator;


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
        // Mencegah semua perintah yang berhubungan dengan 'migrate' dijalankan di semua environment
        $this->app['events']->listen(CommandStarting::class, function ($event) {
            if (strpos($event->command, 'migrate') === 0) {
                echo "Ga boleh {$event->command} sama sekali !!.\n";
                exit(1); // Mengakhiri proses dengan kode error 1
            }
        });

        // Menggunakan Tailwind CSS untuk pagination
        Paginator::useTailwind();
    }
}
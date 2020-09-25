<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array|null
     */
    private $methods;

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
        $this->app->booted(function () {
            $this->callMethodIfExists('jobs');
        });
    }

    public function jobs(Schedule $schedule)
    {
        $schedule->command('update-cars-base')->monthlyOn(1, '01:00');
    }

    /**
     * @param $method
     * @param  array  $parameters
     */
    protected function callMethodIfExists($method, array $parameters = [])
    {
        if ($this->methodExist($method)) {
            $this->app->call([$this, $method], $parameters);
        }
    }

    /**
     * @param  string  $method
     * @return bool
     */
    protected function methodExist(string $method): bool
    {
        if (null === $this->methods) {
            $this->methods = (array) get_class_methods(static::class);
        }

        return in_array($method, $this->methods);
    }
}

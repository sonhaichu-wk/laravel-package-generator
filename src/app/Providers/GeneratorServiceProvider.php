<?php

namespace HaiCS\Laravel\Generator\Providers;

use HaiCS\Laravel\Generator\Commands\CreateCommandCommand;
use HaiCS\Laravel\Generator\Commands\CreateControllerCommand;
use HaiCS\Laravel\Generator\Commands\CreateEntityCommand;
use HaiCS\Laravel\Generator\Commands\CreatePackageCommand;
use HaiCS\Laravel\Generator\Commands\CreateTestCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Generator service provider
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * Register any package services
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Register any package commands
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateCommandCommand::class,
                CreatePackageCommand::class,
                CreateEntityCommand::class,
                CreateTestCommand::class,
                CreateControllerCommand::class,
            ]);
        }
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/generator.php' => config_path('generator.php'),
        ]);
    }
}

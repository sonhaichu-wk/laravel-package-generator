<?php

namespace HaiCS\Laravel\Generator\Test;

use HaiCS\Laravel\Generator\Providers\GeneratorServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return HaiCS\Laravel\Generator\Providers\GeneratorServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [GeneratorServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('filesystems.disks.root', [
            'driver' => 'local',
            'root'   => base_path(),
        ]);
        $app['config']->set('generator.disk', 'root');
        $app['config']->set('generator.module', [
            'root' => 'modules',
        ]);
        $app['config']->set('generator.scaffolding', __DIR__ . '/../scaffolding');
        $app['config']->set('generator.stubs', [
            'command'              => __DIR__ . '/../stubs/Command.stub',
            'entity'               => __DIR__ . '/../stubs/Entity.stub',
            'controller'           => __DIR__ . '/../stubs/Controller.stub',
            'repository_interface' => __DIR__ . '/../stubs/Repository.stub',
            'repository_eloquent'  => __DIR__ . '/../stubs/RepositoryEloquent.stub',
            'repository'           => __DIR__ . '/../stubs/Repository.stub',
            'validator'            => __DIR__ . '/../stubs/Validator.stub',
            'test'                 => __DIR__ . '/../stubs/Test.stub',
            'provider'             => __DIR__ . '/../stubs/ServiceProvider.stub',
            'transformer'          => __DIR__ . '/../stubs/Transformer.stub',
            'event'                => __DIR__ . '/../stubs/Event.stub',
            'listener'             => __DIR__ . '/../stubs/Listener.stub',
            'notification'         => __DIR__ . '/../stubs/Notification.stub',
            'migration'            => __DIR__ . '/../stubs/Migration.stub',
        ]);
    }
}

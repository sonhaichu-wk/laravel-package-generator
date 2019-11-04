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
            'command'    => __DIR__ . '/../stubs/Command.stub',
            'entity'     => __DIR__ . '/../stubs/Entity.stub',
            'controller' => __DIR__ . '/../stubs/Controller.stub',
            'repository' => __DIR__ . '/../stubs/Repository.stub',
            'validator'  => __DIR__ . '/../stubs/Validator.stub',
        ]);
    }
}

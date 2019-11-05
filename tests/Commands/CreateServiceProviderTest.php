<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateServiceProviderTest extends CommandTestCase
{
    /**
     * Get create service provider command to run
     *
     * @return string
     */
    protected function getCreateServiceProviderCommand($provider_name)
    {
        return 'make:package:provider ' . $this->packageName . ' ' . $provider_name;
    }

    /**
     * @test
     */
    public function can_create_service_provider()
    {
        $provider_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateServiceProviderCommand($provider_name))
            ->expectsOutPut('Service provider generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_service_provider_recursively()
    {
        $provider_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateServiceProviderCommand($provider_name))
            ->expectsOutPut('Service provider generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_service_provider_if_service_provider_already_existed()
    {
        $provider_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateServiceProviderCommand($provider_name))
            ->expectsOutPut('Service provider generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateServiceProviderCommand($provider_name))
            ->expectsOutPut('Service provider already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_service_provider_if_package_does_not_exist()
    {
        $provider_name = 'example/example';

        $this->artisan($this->getCreateServiceProviderCommand($provider_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

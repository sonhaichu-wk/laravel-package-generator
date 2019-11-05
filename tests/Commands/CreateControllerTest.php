<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateControllerTest extends CommandTestCase
{
    /**
     * Get command to run
     *
     * @return string
     */
    protected function getCreateControllerCommand($controller_name)
    {
        return 'make:package:controller ' . $this->packageName . ' ' . $controller_name;
    }

    /**
     * @test
     */
    public function can_create_controller()
    {
        $controller_name = 'test';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateControllerCommand($controller_name))
            ->expectsOutput('Controller generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_controller_recursively()
    {
        $controller_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateControllerCommand($controller_name))
            ->expectsOutput('Controller generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_controller_file_if_controller_already_existed()
    {
        $controller_name = 'test';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateControllerCommand($controller_name))
            ->expectsOutput('Controller generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateControllerCommand($controller_name))
            ->expectsOutput('Controller already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_controller_file_if_package_does_not_exist()
    {
        $controller_name = 'test';

        $this->artisan($this->getCreateControllerCommand($controller_name))
            ->expectsOutput('Package does not exist')
            ->assertExitCode(1);
    }
}

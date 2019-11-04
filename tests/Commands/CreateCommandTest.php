<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateCommandTest extends CommandTestCase
{
    /**
     * Get command to run
     *
     * @return string
     */
    protected function getCreateCommandCommand($command_name)
    {
        return 'make:package:command ' . $this->packageName . ' ' . $command_name;
    }

    /**
     * @test
     */
    public function can_create_command()
    {
        $command_name = 'test';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateCommandCommand($command_name))
            ->expectsOutput('Command generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_command_recursively()
    {
        $command_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateCommandCommand($command_name))
            ->expectsOutput('Test generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_command_file_if_command_already_existed()
    {
        $command_name = 'test';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateCommandCommand($command_name))
            ->expectsOutput('Command generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateCommandCommand($command_name))
            ->expectsOutput('Command already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_command_file_if_package_does_not_exist()
    {
        $command_name = 'test';

        $this->artisan($this->getCreateCommandCommand($command_name))
            ->expectsOutput('Package does not exist')
            ->assertExitCode(1);
    }
}

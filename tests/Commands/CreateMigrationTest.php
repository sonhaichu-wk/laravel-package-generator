<?php

namespace HaiCS\Laravel\Generator\Test;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateMigrationTest extends CommandTestCase
{
    /**
     * Get command to run
     *
     * @return string
     */
    protected function getCreateMigrationCommand($command_name)
    {
        return 'make:package:migration ' . $this->packageName . ' ' . $command_name;
    }

    /**
     * @test
     */
    public function can_create_migrations()
    {
        $command_name = 'create_tests_table';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateMigrationCommand($command_name))
            ->expectsOutput('Migration generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_command_file_if_package_does_not_exist()
    {
        $command_name = 'create_tests_table';

        $this->artisan($this->getCreateMigrationCommand($command_name))
            ->expectsOutput('Package does not exist')
            ->assertExitCode(1);
    }
}

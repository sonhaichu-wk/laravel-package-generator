<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateTestTest extends CommandTestCase
{
    /**
     * Get create test command to run
     *
     * @return string
     */
    protected function getCreateTestCommand($test_name)
    {
        return 'make:package:test ' . $this->packageName . ' ' . $test_name;
    }

    /**
     * @test
     */
    public function can_create_test()
    {
        $test_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTestCommand($test_name))
            ->expectsOutPut('Test generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_test_recursively()
    {
        $test_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTestCommand($test_name))
            ->expectsOutPut('Test generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_test_if_test_already_existed()
    {
        $test_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTestCommand($test_name))
            ->expectsOutPut('Test generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateTestCommand($test_name))
            ->expectsOutPut('Test already existed')
            ->assertExitCode(1);
    }
}

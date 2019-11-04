<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreatePackageTest extends CommandTestCase
{
    /**
     * @test
     */
    public function can_create_package()
    {
        $this->artisan($this->getCreatePackageCommand())
            ->expectsOutput('Package generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_package_if_package_already_existed()
    {
        $this->artisan($this->getCreatePackageCommand())
            ->expectsOutput('Package generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreatePackageCommand())
            ->expectsOutput('Package already existed')
            ->assertExitCode(1);
    }
}

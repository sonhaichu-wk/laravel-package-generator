<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateEntityTest extends CommandTestCase
{
    /**
     * Get create test command to run
     *
     * @return string
     */
    protected function getCreateEntityCommand($entity_name)
    {
        return 'make:package:entity ' . $this->packageName . ' ' . $entity_name;
    }

    /**
     * @test
     */
    public function can_create_entity()
    {
        $entity_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEntityCommand($entity_name))
            ->expectsOutPut('Entity generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_entity_recursively()
    {
        $entity_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEntityCommand($entity_name))
            ->expectsOutPut('Entity generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_entity_if_entity_already_existed()
    {
        $entity_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEntityCommand($entity_name))
            ->expectsOutPut('Entity generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateEntityCommand($entity_name))
            ->expectsOutPut('Entity already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_entity_if_package_does_not_exist()
    {
        $entity_name = 'example/example';

        $this->artisan($this->getCreateEntityCommand($entity_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

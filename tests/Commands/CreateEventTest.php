<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateEventTest extends CommandTestCase
{
    /**
     * Get create event command to run
     *
     * @return string
     */
    protected function getCreateEventCommand($event_name)
    {
        return 'make:package:event ' . $this->packageName . ' ' . $event_name;
    }

    /**
     * @test
     */
    public function can_create_event()
    {
        $event_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEventCommand($event_name))
            ->expectsOutPut('Event generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_event_recursively()
    {
        $event_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEventCommand($event_name))
            ->expectsOutPut('Event generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_event_if_event_already_existed()
    {
        $event_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateEventCommand($event_name))
            ->expectsOutPut('Event generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateEventCommand($event_name))
            ->expectsOutPut('Event already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_event_if_package_does_not_exist()
    {
        $event_name = 'example/example';

        $this->artisan($this->getCreateEventCommand($event_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

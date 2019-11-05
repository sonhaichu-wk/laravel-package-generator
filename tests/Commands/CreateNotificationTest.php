<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateNotificationTest extends CommandTestCase
{
    /**
     * Get create notification command to run
     *
     * @return string
     */
    protected function getCreateNotificationCommand($notification_name)
    {
        return 'make:package:notification ' . $this->packageName . ' ' . $notification_name;
    }

    /**
     * @test
     */
    public function can_create_notification()
    {
        $notification_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateNotificationCommand($notification_name))
            ->expectsOutPut('Notification generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_notification_recursively()
    {
        $notification_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateNotificationCommand($notification_name))
            ->expectsOutPut('Notification generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_notification_if_notification_already_existed()
    {
        $notification_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateNotificationCommand($notification_name))
            ->expectsOutPut('Notification generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateNotificationCommand($notification_name))
            ->expectsOutPut('Notification already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_notification_if_package_does_not_exist()
    {
        $notification_name = 'example/example';

        $this->artisan($this->getCreateNotificationCommand($notification_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

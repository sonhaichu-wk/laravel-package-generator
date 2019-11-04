<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\TestCase;

/**
 * Create Command test suite
 */
class CreateCommandTest extends TestCase
{
    /**
     * @test
     */
    public function can_create_command_file()
    {
        $this->artisan('make:package:command new_package test')
            ->expectsOutput('Command generate successful');
    }
}

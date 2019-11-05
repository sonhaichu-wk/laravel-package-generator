<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateTransformerTest extends CommandTestCase
{
    /**
     * Get create transformer command to run
     *
     * @return string
     */
    protected function getCreateTransformerCommand($transformer_name)
    {
        return 'make:package:transformer ' . $this->packageName . ' ' . $transformer_name;
    }

    /**
     * @test
     */
    public function can_create_transformer()
    {
        $transformer_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTransformerCommand($transformer_name))
            ->expectsOutPut('Transformer generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_transformer_recursively()
    {
        $transformer_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTransformerCommand($transformer_name))
            ->expectsOutPut('Transformer generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_transformer_if_transformer_already_existed()
    {
        $transformer_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateTransformerCommand($transformer_name))
            ->expectsOutPut('Transformer generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateTransformerCommand($transformer_name))
            ->expectsOutPut('Transformer already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_transformer_if_package_does_not_exist()
    {
        $transformer_name = 'example/example';

        $this->artisan($this->getCreateTransformerCommand($transformer_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

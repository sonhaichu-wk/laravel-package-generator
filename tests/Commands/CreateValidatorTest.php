<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;

class CreateValidatorTest extends CommandTestCase
{
    /**
     * Get create validator command to run
     *
     * @return string
     */
    protected function getCreateValidatorCommand($validator_name)
    {
        return 'make:package:validator ' . $this->packageName . ' ' . $validator_name;
    }

    /**
     * @test
     */
    public function can_create_validator()
    {
        $validator_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateValidatorCommand($validator_name))
            ->expectsOutPut('Validator generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_validator_recursively()
    {
        $validator_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateValidatorCommand($validator_name))
            ->expectsOutPut('Validator generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_validator_if_validator_already_existed()
    {
        $validator_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateValidatorCommand($validator_name))
            ->expectsOutPut('Validator generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateValidatorCommand($validator_name))
            ->expectsOutPut('Validator already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_validator_if_package_does_not_exist()
    {
        $validator_name = 'example/example';

        $this->artisan($this->getCreateValidatorCommand($validator_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }
}

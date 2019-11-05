<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\Commands\CommandTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateRepositoryTest extends CommandTestCase
{
    /**
     * Get create repository command to run
     *
     * @return string
     */
    protected function getCreateRepositoryCommand($repository_name)
    {
        return 'make:package:repository ' . $this->packageName . ' ' . $repository_name;
    }

    /**
     * @test
     */
    public function can_create_repository()
    {
        $repository_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function can_create_repository_recursively()
    {
        $repository_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_repository_if_repository_already_existed()
    {
        $repository_name = 'example/example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository already existed')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function cannot_create_repository_if_package_does_not_exist()
    {
        $repository_name = 'example/example';

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Package does not exist')
            ->assertExitCode(1);
    }

    /**
     * @test
     */
    public function can_create_repository_interface()
    {
        $repository_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository generate successful')
            ->assertExitCode(0);

        Storage::disk('root')->assertExists(config('generator.module.root') . '/' . $this->packageName . '/src/app/Repositories/' . Str::studly($repository_name) . 'Repository.php');
    }

    /**
     * @test
     */
    public function can_create_repository_eloquent()
    {
        $repository_name = 'example';

        $this->artisan($this->getCreatePackageCommand())
            ->assertExitCode(0);

        $this->artisan($this->getCreateRepositoryCommand($repository_name))
            ->expectsOutPut('Repository generate successful')
            ->assertExitCode(0);

        Storage::disk('root')->assertExists(config('generator.module.root') . '/' . $this->packageName . '/src/app/Repositories/' . Str::studly($repository_name) . 'RepositoryEloquent.php');
    }
}

<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\TestCase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreatePackageTest extends TestCase
{
    /**
     * @var string
     */
    protected $packageName;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->packageName = 'new_package';
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $file_system  = app(Filesystem::class);
        $package_path = base_path() . '/' . config('generator.module.root') . '/' . $this->packageName;

        if ($file_system->isDirectory($package_path)) {
            $file_system->deleteDirectory($package_path);
        }
    }

    /**
     * Get command to run
     *
     * @return string
     */
    protected function getCommand()
    {
        return 'make:package ' . $this->packageName;
    }

    /**
     * @test
     */
    public function can_create_package()
    {
        $this->artisan($this->getCommand())
            ->expectsOutput('Package generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    public function cannot_create_package_if_package_already_existed()
    {
        $this->artisan($this->getCommand())
            ->expectsOutput('Package generate successful')
            ->assertExitCode(0);

        $this->artisan($this->getCommand())
            ->expectsOutput('Package already existed')
            ->assertExitCode(1);
    }
}

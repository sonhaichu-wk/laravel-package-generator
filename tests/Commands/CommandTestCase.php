<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\TestCase;
use Illuminate\Filesystem\Filesystem;

class CommandTestCase extends TestCase
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
     * Get create package command to run
     *
     * @return string
     */
    protected function getCreatePackageCommand()
    {
        return 'make:package ' . $this->packageName;
    }
}

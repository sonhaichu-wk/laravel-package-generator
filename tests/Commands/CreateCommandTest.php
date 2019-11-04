<?php

namespace HaiCS\Laravel\Generator\Test\Commands;

use HaiCS\Laravel\Generator\Test\TestCase;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

/**
 * Create Command test suite
 */
class CreateCommandTest extends TestCase
{
    /**
     * @var string
     */
    protected $packageName;

    /**
     * @var string
     */
    protected $commandName;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->packageName = 'new_package';
        $this->commandName = 'test';
    }

    /**
     * This method is called after each test.
     */
    // protected function tearDown(): void
    // {
    //     $file_system  = app(Filesystem::class);
    //     $package_path = base_path() . '/' . config('generator.module.root') . '/' . $this->packageName;

    //     if ($file_system->isDirectory($package_path)) {
    //         $file_system->deleteDirectory($package_path);
    //     }
    // }

    /**
     * Get command to run
     *
     * @return string
     */
    protected function getCommand()
    {
        return 'make:package:command ' . $this->packageName . ' ' . $this->commandName;
    }

    /**
     * @test
     */
    public function can_create_command_file()
    {
        $this->artisan($this->getCommand())
            ->expectsOutput('Command generate successful')
            ->assertExitCode(0);
    }

    /**
     * @test
     */
    // public function cannot_create_command_file_if_command_already_existed()
    // {
    //     // $this->artisan($this->getCommand())
    //     // ->expectsOutput('Command generate successful')
    //     // ->assertExitCode(0);

    //     Artisan::call('make:package:command', [
    //         'packageName' => $this->packageName,
    //         'commandName' => $this->commandName,
    //     ]);
    //     // $class_name  = Str::studly($this->commandName);
    //     // $file_path   = base_path() . '/' . config('generator.module.root') . '/' . $this->packageName . '/src/app/Commands/' . $class_name . 'Command.php';
    //     // $file_system = app(Filesystem::class);

    //     // // dd($file_path);
    //     // dd($file_system->isFile($file_path));

    //     $this->artisan($this->getCommand())
    //         ->expectsOutput('Command already existed')
    //         ->assertExitCode(1);
    // }
}

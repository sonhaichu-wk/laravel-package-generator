<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:test {packageName} {testName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test class in package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $package_name = $this->argument('packageName');
        $test_names   = collect(explode('/', $this->argument('testName')));
        $stub         = $this->getStub();

        try {
            $result = $this->makeTest($package_name, $test_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Test generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.test'));
    }

    /**
     * Create test file
     *
     * @return void
     */
    protected function makeTest($package_name, $test_names, $stub)
    {
        $class_name       = Str::studly($test_names->pop());
        $test_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system      = app(Filesystem::class);
        $package_path     = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $test_folder_path = $package_path . '/tests';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($test_names->count()) {
            $test_names = $test_names->map(function ($item) {
                return Str::studly($item);
            });
            $test_folder_path = $test_folder_path . '/' . implode('/', $test_names->toArray());
            if (!$file_system->isDirectory($test_folder_path)) {
                $file_system->makeDirectory($test_folder_path, 0755, true);
            }
        }

        $file_path = $test_folder_path . '/' . $class_name . 'Test.php';

        if ($file_system->isFile($file_path)) {
            throw new Exception('Test already existed');
        }

        $file_system->put($file_path, $test_template);
    }
}

<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:controller {packageName} {controllerName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller class in package';

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
        $package_name     = $this->argument('packageName');
        $controller_names = collect(explode('/', $this->argument('controllerName')));
        $stub             = $this->getStub();

        try {
            $this->makeEntity($package_name, $controller_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Controller generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.controller'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeEntity($package_name, $controller_names, $stub)
    {
        $class_name             = Str::studly($controller_names->pop());
        $entity_template        = str_replace('{{name}}', $class_name, $stub);
        $file_system            = app(Filesystem::class);
        $package_path           = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $controller_folder_path = $package_path . '/src/app/Http/Controllers';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($controller_names->count()) {
            $controller_names = $controller_names->map(function ($item) {
                return Str::studly($item);
            });
            $controller_folder_path = $controller_folder_path . '/' . implode('/', $controller_names->toArray());
            if (!$file_system->isDirectory($controller_folder_path)) {
                $file_system->makeDirectory($controller_folder_path, 0755, true);
            }
        }

        $file_path = $controller_folder_path . '/' . $class_name . 'Controller.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Controller already existed');
        }

        $file_system->put($file_path, $entity_template);
    }
}

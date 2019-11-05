<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:repository {packageName} {repositoryName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a repository class in package';

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
        $repository_names = collect(explode('/', $this->argument('repositoryName')));
        $interface_stub   = $this->getInterfaceStub();
        $eloquent_stub    = $this->getEloquentStub();

        try {
            $this->makeRepository($package_name, $repository_names, $interface_stub);
            $this->makeRepository($package_name, $repository_names, $eloquent_stub, true);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Repository generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getInterfaceStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.repository_interface'));
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getEloquentStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.repository_eloquent'));
    }

    /**
     * Create repository file
     *
     * @return void
     */
    protected function makeRepository($package_name, $repository_names, $stub, $eloquent = false)
    {
        $names                  = clone $repository_names;
        $class_name             = Str::studly($names->pop());
        $repository_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system            = app(Filesystem::class);
        $package_path           = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $repository_folder_path = $package_path . '/src/app/Repositories';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($names->count()) {
            $names = $names->map(function ($item) {
                return Str::studly($item);
            });
            $repository_folder_path = $repository_folder_path . '/' . implode('/', $names->toArray());
            if (!$file_system->isDirectory($repository_folder_path)) {
                $file_system->makeDirectory($repository_folder_path, 0755, true);
            }
        }

        $file_path = $eloquent ? $repository_folder_path . '/' . $class_name . 'RepositoryEloquent.php' : $repository_folder_path . '/' . $class_name . 'Repository.php';

        if ($file_system->isFile($file_path)) {
            throw new Exception('Repository already existed');
        }

        $file_system->put($file_path, $repository_template);
    }
}

<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:entity {packageName} {entityName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an entity class in package';

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
        $entity_names = collect(explode('/', $this->argument('entityName')));
        $stub         = $this->getStub();

        try {
            $this->makeEntity($package_name, $entity_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Entity generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.entity'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeEntity($package_name, $entity_names, $stub)
    {
        $class_name         = Str::studly($entity_names->pop());
        $entity_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system        = app(Filesystem::class);
        $package_path       = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $entity_folder_path = $package_path . '/src/app/Entities';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($entity_names->count()) {
            $entity_names = $entity_names->map(function ($item) {
                return Str::studly($item);
            });
            $entity_folder_path = $entity_folder_path . '/' . implode('/', $entity_names->toArray());
            if (!$file_system->isDirectory($entity_folder_path)) {
                $file_system->makeDirectory($entity_folder_path, 0755, true);
            }
        }

        $file_path = $entity_folder_path . '/' . $class_name . 'Entity.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Entity already existed');
        }

        $file_system->put($file_path, $entity_template);
    }
}

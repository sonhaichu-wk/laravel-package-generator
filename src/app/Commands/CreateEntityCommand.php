<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
        $entity_name  = $this->argument('entityName');
        $stub         = $this->getStub();
        $this->makeEntity($package_name, $entity_name, $stub);
        $this->info('Entity generate successful');
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.module.root') . '/generator/stubs/Entity.stub');
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeEntity($package_name, $entity_name, $stub)
    {
        $class_name      = Str::studly($entity_name);
        $entity_template = str_replace('{{name}}', $class_name, $stub);
        app(Filesystem::class)->put(config('generator.module.root') . '/' . $package_name . '/src/app/Entities/' . $class_name . '.php', $entity_template);
    }
}

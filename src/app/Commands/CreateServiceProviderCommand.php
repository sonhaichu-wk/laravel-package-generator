<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateServiceProviderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:provider {packageName} {providerName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an service provider class in package';

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
        $package_name   = $this->argument('packageName');
        $provider_names = collect(explode('/', $this->argument('providerName')));
        $stub           = $this->getStub();

        try {
            $this->makeServiceProvider($package_name, $provider_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Service provider generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.provider'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeServiceProvider($package_name, $provider_names, $stub)
    {
        $class_name           = Str::studly($provider_names->pop());
        $provider_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system          = app(Filesystem::class);
        $package_path         = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $provider_folder_path = $package_path . '/src/app/Providers';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($provider_names->count()) {
            $provider_names = $provider_names->map(function ($item) {
                return Str::studly($item);
            });
            $provider_folder_path = $provider_folder_path . '/' . implode('/', $provider_names->toArray());
            if (!$file_system->isDirectory($provider_folder_path)) {
                $file_system->makeDirectory($provider_folder_path, 0755, true);
            }
        }

        $file_path = $provider_folder_path . '/' . $class_name . 'ServiceProvider.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Service provider already existed');
        }

        $file_system->put($file_path, $provider_template);
    }
}

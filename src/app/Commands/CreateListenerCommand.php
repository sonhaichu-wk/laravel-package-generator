<?php

namespace HaiCS\Laravel\Generator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateListenerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:listener {packageName} {listenerName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a listener class in package';

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
        $listener_names = collect(explode('/', $this->argument('listenerName')));
        $stub           = $this->getStub();

        try {
            $this->makeListener($package_name, $listener_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Listener generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.listener'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeListener($package_name, $listener_names, $stub)
    {
        $class_name           = Str::studly($listener_names->pop());
        $listener_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system          = app(Filesystem::class);
        $package_path         = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $listener_folder_path = $package_path . '/src/app/Listeners';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($listener_names->count()) {
            $listener_names = $listener_names->map(function ($item) {
                return Str::studly($item);
            });
            $listener_folder_path = $listener_folder_path . '/' . implode('/', $listener_names->toArray());
            if (!$file_system->isDirectory($listener_folder_path)) {
                $file_system->makeDirectory($listener_folder_path, 0755, true);
            }
        }

        $file_path = $listener_folder_path . '/' . $class_name . 'Listener.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Listener already existed');
        }

        $file_system->put($file_path, $listener_template);
    }
}

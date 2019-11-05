<?php

namespace HaiCS\Laravel\Generator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateEventCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:event {packageName} {eventName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an event class in package';

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
        $event_names  = collect(explode('/', $this->argument('eventName')));
        $stub         = $this->getStub();

        try {
            $this->makeEvent($package_name, $event_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Event generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.event'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeEvent($package_name, $event_names, $stub)
    {
        $class_name        = Str::studly($event_names->pop());
        $event_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system       = app(Filesystem::class);
        $package_path      = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $event_folder_path = $package_path . '/src/app/Events';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($event_names->count()) {
            $event_names = $event_names->map(function ($item) {
                return Str::studly($item);
            });
            $event_folder_path = $event_folder_path . '/' . implode('/', $event_names->toArray());
            if (!$file_system->isDirectory($event_folder_path)) {
                $file_system->makeDirectory($event_folder_path, 0755, true);
            }
        }

        $file_path = $event_folder_path . '/' . $class_name . 'Event.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Event already existed');
        }

        $file_system->put($file_path, $event_template);
    }
}

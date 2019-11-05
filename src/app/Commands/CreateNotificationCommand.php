<?php

namespace HaiCS\Laravel\Generator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:notification {packageName} {notificationName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a notification class in package';

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
        $package_name       = $this->argument('packageName');
        $notification_names = collect(explode('/', $this->argument('notificationName')));
        $stub               = $this->getStub();

        try {
            $this->makeNotification($package_name, $notification_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Notification generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.notification'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeNotification($package_name, $notification_names, $stub)
    {
        $class_name               = Str::studly($notification_names->pop());
        $notification_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system              = app(Filesystem::class);
        $package_path             = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $notification_folder_path = $package_path . '/src/app/Notifications';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($notification_names->count()) {
            $notification_names = $notification_names->map(function ($item) {
                return Str::studly($item);
            });
            $notification_folder_path = $notification_folder_path . '/' . implode('/', $notification_names->toArray());
            if (!$file_system->isDirectory($notification_folder_path)) {
                $file_system->makeDirectory($notification_folder_path, 0755, true);
            }
        }

        $file_path = $notification_folder_path . '/' . $class_name . 'Notification.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Notification already existed');
        }

        $file_system->put($file_path, $notification_template);
    }
}

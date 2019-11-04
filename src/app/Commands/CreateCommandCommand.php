<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Exception;

class CreateCommandCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:command {packageName} {commandName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a command class in package';

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
        $package_name  = $this->argument('packageName');
        $command_names = collect(explode('/', $this->argument('commandName')));
        $stub          = $this->getStub();

        try {
            $this->makeCommand($package_name, $command_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Command generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.command'));
    }

    /**
     * Create command file
     *
     * @return void
     */
    protected function makeCommand($package_name, $command_names, $stub)
    {
        $class_name          = Str::studly($command_names->pop());
        $command_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system         = app(Filesystem::class);
        $package_path        = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $command_folder_path = $package_path . '/src/app/Commands';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($command_names->count()) {
            $command_names = $command_names->map(function ($item) {
                return Str::studly($item);
            });
            $command_folder_path = $command_folder_path . '/' . implode('/', $command_names->toArray());
            if (!$file_system->isDirectory($command_folder_path)) {
                $file_system->makeDirectory($command_folder_path, 0755, true);
            }
        }

        $file_path = $command_folder_path . '/' . $class_name . 'Command.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Command already existed');
        }

        $file_system->put($file_path, $command_template);
    }
}

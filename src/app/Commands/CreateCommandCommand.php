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
        $package_name = $this->argument('packageName');
        $command_name = $this->argument('commandName');
        $stub         = $this->getStub();

        try {
            $result = $this->makeCommand($package_name, $command_name, $stub);
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
    protected function makeCommand($package_name, $command_name, $stub)
    {
        $class_name       = Str::studly($command_name);
        $command_template = str_replace('{{name}}', $class_name, $stub);
        $file_path        = config('generator.module.root') . '/' . $package_name . '/src/app/Commands/' . $class_name . 'Command.php';
        $file_system      = app(Filesystem::class);

        if ($file_system->isFile($file_path)) {
            throw new Exception('Command already existed');
        }

        $file_system->put($file_path, $command_template);
    }
}

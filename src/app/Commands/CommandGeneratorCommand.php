<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Exception;

class CommandGeneratorCommand extends Command
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
        $this->makeCommand($package_name, $command_name, $stub);
        $this->info('Command generate successful');
    }

    protected function getStub()
    {
        return Storage::disk('root')->get('modules/generator/stubs/Command.stub');
    }

    protected function makeCommand($package_name, $command_name, $stub)
    {
        $class_name       = Str::studly($command_name);
        $command_template = str_replace('{{name}}', $class_name, $stub);
        Storage::disk('root')->put('modules/' . $package_name . '/src/app/Commands/' . $class_name . 'Command.php', $command_template);
    }
}

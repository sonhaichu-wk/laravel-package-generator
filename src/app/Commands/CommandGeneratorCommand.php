<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use \Exception;

class CommandGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:command {name}';

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
        $name = $this->argument('name');
        $stub = $this->getStub();
        $this->makeCommand($name, $stub);
        $this->info('Command generate successful');
    }

    protected function getStub()
    {
        return file_get_contents(__DIR__ . '/../../../stubs/Command.stub');
    }

    protected function makeCommand($name, $stub)
    {
        $class_name       = Str::studly($name);
        $command_template = str_replace('{{name}}', $class_name, $stub);
        file_put_contents(__DIR__ . '/../../../../test/' . $class_name . 'Command.php', $command_template);
    }
}

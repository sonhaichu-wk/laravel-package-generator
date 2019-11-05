<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateValidatorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:validator {packageName} {validatorName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a validator class in package';

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
        $package_name    = $this->argument('packageName');
        $validator_names = collect(explode('/', $this->argument('validatorName')));
        $stub            = $this->getStub();

        try {
            $this->makeValidator($package_name, $validator_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Validator generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.validator'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeValidator($package_name, $validator_names, $stub)
    {
        $class_name            = Str::studly($validator_names->pop());
        $validator_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system           = app(Filesystem::class);
        $package_path          = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $validator_folder_path = $package_path . '/src/app/Validators';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($validator_names->count()) {
            $validator_names = $validator_names->map(function ($item) {
                return Str::studly($item);
            });
            $validator_folder_path = $validator_folder_path . '/' . implode('/', $validator_names->toArray());
            if (!$file_system->isDirectory($validator_folder_path)) {
                $file_system->makeDirectory($validator_folder_path, 0755, true);
            }
        }

        $file_path = $validator_folder_path . '/' . $class_name . 'Validator.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Validator already existed');
        }

        $file_system->put($file_path, $validator_template);
    }
}

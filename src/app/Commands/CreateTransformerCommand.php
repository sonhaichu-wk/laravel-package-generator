<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreateTransformerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:transformer {packageName} {transformerName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a transformer class in package';

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
        $package_name      = $this->argument('packageName');
        $transformer_names = collect(explode('/', $this->argument('transformerName')));
        $stub              = $this->getStub();

        try {
            $this->makeTransformer($package_name, $transformer_names, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Transformer generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.transformer'));
    }

    /**
     * Create entity file
     *
     * @return void
     */
    protected function makeTransformer($package_name, $transformer_names, $stub)
    {
        $class_name              = Str::studly($transformer_names->pop());
        $transformer_template    = str_replace('{{name}}', $class_name, $stub);
        $file_system             = app(Filesystem::class);
        $package_path            = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $transformer_folder_path = $package_path . '/src/app/Transformers';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        if ($transformer_names->count()) {
            $transformer_names = $transformer_names->map(function ($item) {
                return Str::studly($item);
            });
            $transformer_folder_path = $transformer_folder_path . '/' . implode('/', $transformer_names->toArray());
            if (!$file_system->isDirectory($transformer_folder_path)) {
                $file_system->makeDirectory($transformer_folder_path, 0755, true);
            }
        }

        $file_path = $transformer_folder_path . '/' . $class_name . 'Transformer.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Transformer already existed');
        }

        $file_system->put($file_path, $transformer_template);
    }
}

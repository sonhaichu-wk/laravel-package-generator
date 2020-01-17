<?php

namespace HaiCS\Laravel\Generator\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class CreateMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:migration {packageName} {migrationName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a migration file in package';

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
        $migration_name = $this->argument('migrationName');
        $stub           = $this->getStub();

        try {
            $this->makeCommand($package_name, $migration_name, $stub);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Migration generate successful');

        return 0;
    }

    /**
     * Get content in stub file
     *
     * @return string
     */
    protected function getStub()
    {
        return app(Filesystem::class)->get(config('generator.stubs.migration'));
    }

    /**
     * Create command file
     *
     * @return void
     */
    protected function makeCommand($package_name, $migration_name, $stub)
    {
        preg_match('/[a-z]+_table/', $migration_name, $result);
        $table_name             = Str::lower(explode('_', $result[0])[0]);
        $class_name             = Str::studly($migration_name);
        $migration_template     = str_replace('{{className}}', $class_name, $stub);
        $migration_template     = str_replace('{{tableName}}', $table_name, $migration_template);
        $file_system            = app(Filesystem::class);
        $package_path           = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $migrations_folder_path = $package_path . '/src/database/migrations';

        if (!$file_system->isDirectory($package_path)) {
            throw new Exception('Package does not exist');
        }

        $file_path = $migrations_folder_path . '/' . date('Y_m_d_His', time()) . '_' . $migration_name . '.php';
        if ($file_system->isFile($file_path)) {
            throw new Exception('Migration already existed');
        }

        $file_system->put($file_path, $migration_template);
    }
}

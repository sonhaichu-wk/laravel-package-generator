<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use \Exception;

class CreatePackageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a package scaffolding folder';

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

        try {
            $this->makePackage($name);
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Package generate successful');

        return 0;
    }

    /**
     * Create package scaffolding folder
     *
     * @return void
     */
    protected function makePackage($name)
    {
        $package_name = Str::snake($name);
        $dir          = config('generator.scaffolding');
        $dest         = base_path() . '/' . config('generator.module.root') . '/' . $package_name;
        $file_system  = app(Filesystem::class);

        if ($file_system->isDirectory($dest)) {
            throw new Exception('Package already existed');
        }

        $file_system->copyDirectory($dir, $dest);
    }
}

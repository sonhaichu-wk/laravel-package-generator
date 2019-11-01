<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

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
        $this->makePackage($name);
        $this->info('Package generate successful');
    }

    /**
     * Create package scaffolding folder
     *
     * @return void
     */
    protected function makePackage($name)
    {
        $package_name = Str::snake($name);
        $dir          = config('generator.module.root') . '/' . config('generator.module.scaffolding');
        $dest         = config('generator.module.root') . '/' . $package_name;
        app(Filesystem::class)->copyDirectory($dir, $dest);
    }
}

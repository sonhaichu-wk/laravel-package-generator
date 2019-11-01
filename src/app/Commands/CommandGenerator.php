<?php

namespace HaiCS\Laravel\Generator\Commands;

use Illuminate\Console\Command;

class CommandGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:package:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command class in package generator command';

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
        dd('generate command success');
    }
}

<?php

namespace App\Console\Commands;

use App\Services\GoogleDataService;
use Illuminate\Console\Command;

class RunScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-script';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run specified command in google scripts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new GoogleDataService();
        echo $service->script;
        $result = $service->runScript('expandMessage', ['hey, ya', 'whats going on?']);
        echo $result;
    }
}

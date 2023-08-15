<?php

namespace App\Console\Commands;

use App\Models\TaskSushi;
use Illuminate\Console\Command;

class TestSushi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-task-sushi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return values from google sheet through API call as a Sushi Model';

    public function handle()
    {
        $sushi = TaskSushi::all()->dd();
    }
}

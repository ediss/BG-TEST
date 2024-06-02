<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\FetchFilesData;

class DispatchFetchFilesDataJob extends Command
{
    protected $signature = 'fetch:files-data';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        FetchFilesData::dispatch();
    }
}

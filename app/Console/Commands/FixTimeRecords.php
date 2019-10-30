<?php

namespace App\Console\Commands;

use App\Time\Session;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FixTimeRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'records:fix';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix incorrect records from month off by bug';

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
        $affected = Session::where('created_at', '>=', Carbon::parse('2019-10-28'))->get();
        $affected->each(function($record) {
            $record->start_time = Carbon::parse($record->start_time)->addMonth();
            $record->end_time = Carbon::parse($record->end_time)->addMonth();
            $record->save();
        });
    }
}

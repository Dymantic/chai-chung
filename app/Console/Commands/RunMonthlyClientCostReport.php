<?php

namespace App\Console\Commands;

use App\Reports\ClientCostSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RunMonthlyClientCostReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:client-cost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run report for client cost from previous full month';

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
        $start = Carbon::parse('first day of last month');
        $end = Carbon::parse('last day of last month');

        $summary = new ClientCostSummary($start, $end);
        $summary->save();
    }
}

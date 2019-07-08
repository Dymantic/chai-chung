<?php

namespace App\Console\Commands;

use App\Reports\StaffCostSummary;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RunMonthlyStaffCostReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:monthly-staff-cost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run and save the monthly staff cost reports';

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
        $month_start = Carbon::today()->subMonth()->firstOfMonth();
        $month_end = Carbon::today()->subMonth()->lastOfMonth();

        $summary = new StaffCostSummary($month_start, $month_end);
        $summary->save();
    }
}

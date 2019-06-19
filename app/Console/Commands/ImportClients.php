<?php

namespace App\Console\Commands;

use App\Imports\ClientsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportClients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import list of clients';

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
        Excel::import(new ClientsImport, 'imports/clients.csv');
    }
}

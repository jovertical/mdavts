<?php

namespace App\Console\Commands;

use App\Election;
use Illuminate\Console\Command;

class ElectionActivator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:activator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate Election';

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
        $upcoming_elections = Election::where('status', 'upcoming')
            ->where('start_date', now()->format('Y-m-d'))
            ->get();

        foreach ($upcoming_elections as $election) {
            $election->status = 'active';
            $election->update();
        }
    }
}

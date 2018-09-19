<?php

namespace App\Console\Commands;

use App\Election;
use Illuminate\Console\Command;

class ElectionCloser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:closer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close Election';

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
        $ending_elections = Election::where('status', 'active')
            ->where('end_date', now()->format('Y-m-d'))
            ->get();

        foreach ($ending_elections as $election) {
            $election->status = 'closed';
            $election->update();
        }
    }
}

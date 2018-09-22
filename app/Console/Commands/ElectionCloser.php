<?php

namespace App\Console\Commands;

use App\Election;
use Illuminate\Support\Collection;
use Illuminate\Console\Command;

class ElectionCloser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:closer {--force}';

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
        $this->info("Initializing...");

        $allActiveElections = Election::where('status', 'active')->get();

        $endingActiveElections = Election::where('status', 'active')
            ->where('end_date', now()->format('Y-m-d'))
            ->get();

        $this->updateElectionStatus(
            $this->option('force') ? $allActiveElections : $endingActiveElections
        );
    }

    /**
     * @param Illuminate\Support\Collection
     * @return void
     */
    protected function updateElectionStatus(Collection $elections) : void
    {
        foreach ($elections as $election) {
            $election->status = 'closed';

            $this->info("Closing: {$election->name}");

            $election->update();

            $this->comment("Closed: {$election->name}");
        }
    }
}
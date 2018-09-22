<?php

namespace App\Console\Commands;

use App\Election;
use Illuminate\Support\Collection;
use Illuminate\Console\Command;

class ElectionOpener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'election:opener {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open Election';

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

        $allUpcomingElections = Election::where('status', 'upcoming')->get();

        $todayUpcomingElections = Election::where('status', 'upcoming')
            ->where('start_date', now()->format('Y-m-d'))
            ->get();

        $this->updateElectionStatus(
            $this->option('force') ? $allUpcomingElections : $todayUpcomingElections
        );
    }

    /**
     * @param Illuminate\Support\Collection
     * @return void
     */
    protected function updateElectionStatus(Collection $elections) : void
    {
        foreach ($elections as $election) {
            $election->status = 'active';

            $this->info("Opening: {$election->name}");

            $election->update();

            $this->comment("Opened: {$election->name}");
        }
    }
}

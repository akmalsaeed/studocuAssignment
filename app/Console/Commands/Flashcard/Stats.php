<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\FlashcardHelper;
use Illuminate\Console\Command;

class Stats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View Flashcard Statistics';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stats = FlashcardHelper::stats();
        $this->info(__("label.flashcard.stats.questions"). $stats['Questions']);
        $this->info(__("label.flashcard.stats.answered"). $stats['Answered']);
        $this->info(__("label.flashcard.stats.correct"). $stats['Correct']);
        $this->ask(__("label.flashcard.return"));
        $this->call('flashcard:interactive');
    }
}

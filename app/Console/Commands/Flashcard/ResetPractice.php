<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\FlashcardHelper;
use Illuminate\Console\Command;

class ResetPractice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all flashcards of user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->confirm(__("label.flashcard.reset.confirm"), true)) {
            FlashcardHelper::reset();
            $this->info(__("label.flashcard.reset.deleted"));
            $this->ask(__("label.flashcard.return"));
            $this->call('flashcard:interactive');
        }
    }
}

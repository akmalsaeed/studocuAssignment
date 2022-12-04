<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\FlashcardHelper;
use Illuminate\Console\Command;

class ListAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Flashcards';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->table(
            ['Question', 'Answer'],
            FlashcardHelper::list()
        );
        $this->ask(__("label.flashcard.return"));
        $this->call("flashcard:interactive");

        return 0;
    }
}

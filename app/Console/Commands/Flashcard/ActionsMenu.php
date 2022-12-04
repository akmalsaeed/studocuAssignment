<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\Console\ConsoleHelper;
use Illuminate\Console\Command;

class ActionsMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command shows the main menu';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $selectedMenuItem = $this->choice(
            __("label.flashcard.menu.welcome"),
            [
                __("label.flashcard.menu.create"),
                __("label.flashcard.menu.list"),
                __("label.flashcard.menu.practice"),
                __("label.flashcard.menu.stats"),
                __("label.flashcard.menu.reset"),
                __("label.flashcard.menu.exit")
            ],
            0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );


        switch ($selectedMenuItem){
            case __("label.flashcard.menu.create"):
                ConsoleHelper::clearConsole();
                $this->call("flashcard:create");
                break;
            case __("label.flashcard.menu.list"):
                ConsoleHelper::clearConsole();
                $this->call("flashcard:list");
                break;
            case __("label.flashcard.menu.practice"):
                ConsoleHelper::clearConsole();
                $this->call("flashcard:practice");
                break;
            case __("label.flashcard.menu.stats"):
                ConsoleHelper::clearConsole();
                $this->call("flashcard:stats");
                break;
            case __("label.flashcard.menu.reset"):
                ConsoleHelper::clearConsole();
                $this->call("flashcard:reset");
                break;
        }    }
}

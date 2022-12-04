<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\FlashcardHelper;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class Practice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table = new Table($this->output);
        $table->setHeaders(['ID','Question','Status']);
        $table->addRows(FlashcardHelper::listWithPracticeStatus());
        $table->setFooterTitle("%".FlashcardHelper::getPercentageOfCompletion().__("label.flashcard.practice.percentage_comp"));
        $table->render();
        $questionId = $this->ask(__("label.flashcard.practice.choose_question"));
        if ($questionId == 0){
            $this->call("flashcard:interactive");
            return 0;
        }

        try {
            $flashcard = FlashcardHelper::fetchFlashcardForPractice($questionId);
            $this->info(__("label.flashcard.practice.selected_question").$flashcard->question);
            $answer = $this->ask(__("label.flashcard.practice.type_answer"));
            $status = FlashcardHelper::answerQuestion($flashcard, $answer);
            $this->info(__('label.flashcard.practice.answered') . __('label.flashcard.practice.status.'.$status));
            $this->call('flashcard:practice');
            return 0;

        }catch (\Exception $e){
            $this->error($e->getMessage());
            $this->ask(__("label.flashcard.return"));
            $this->call("flashcard:practice");
            return 0;
        }
    }
}

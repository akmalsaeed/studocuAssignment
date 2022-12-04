<?php

namespace App\Console\Commands\Flashcard;

use App\Helpers\FlashcardHelper;
use App\Models\DataModels\FlashcardModel;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class Create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Flashcard';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $input['question'] = $this->ask(__("label.flashcard.create.question"));
        if ($input['question'] == 0)
        {
            $this->call("flashcard:interactive");
            return 0;
        }
        $input['answer'] = $this->ask(__("label.flashcard.create.answer"));

        try {
            FlashcardHelper::create($input);
            $this->info(__("label.flashcard.create.created"));
            $this->call("flashcard:interactive");
        }catch (ValidationException $e){
            $this->error($e->getMessage());
            $this->call("flashcard:create");
        }
    }
}

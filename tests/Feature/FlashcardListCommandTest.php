<?php

namespace Tests\Feature;

use App\Models\Flashcard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FlashcardListCommandTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     * @return void
     */
    public function test_flashcard_list()
    {
       Flashcard::create([
            'question' => FlashcardFixtures::QUESTION,
            'answer' => FlashcardFixtures::ANSWER
        ]);
         $this->artisan('flashcard:list')
             ->expectsTable(['Question', 'Answer'], [[FlashcardFixtures::QUESTION, FlashcardFixtures::ANSWER]])
             ->expectsQuestion(__('label.flashcard.return'), 0)
             ->expectsQuestion(__('label.flashcard.menu.welcome'), 5)
            ->assertExitCode(0);

    }

}

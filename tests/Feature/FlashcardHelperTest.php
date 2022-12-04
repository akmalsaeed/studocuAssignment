<?php

namespace Tests\Feature;

use App\Helpers\FlashcardHelper;
use App\Helpers\Exceptions\NotFoundException;
use App\Helpers\Exceptions\PracticeAllowanceException;
use App\StatusCodes;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FlashcardHelperTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void{
        parent::setUp();
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_creating_flashcard_given_invalid_input_should_throw_exception()
    {
        $this->expectException(ValidationException::class);
        $input['question'] = FlashcardFixtures::QUESTION;
        FlashcardHelper::create($input);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_creating_flashcard_given_valid_input_should_return_the_flashcard()
    {
        $input['question'] = FlashcardFixtures::QUESTION;
        $input['answer'] = FlashcardFixtures::ANSWER;
        $result = FlashcardHelper::create($input);
        $this->assertEquals(FlashcardFixtures::QUESTION, $result->question);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_listWithPracticeStatus_when_should_return_flashcard_with_not_answered_status()
    {
        FlashcardFixtures::createNotAnsweredFlashcard();
        $result = FlashcardHelper::listWithPracticeStatus();
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(__("label.flashcard.practice.status.not_answered"), $result[0]['Status']);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_listWithPracticeStatus_when_should_return_flashcard_with_correct_status()
    {
        FlashcardFixtures::createCorrectAnsweredFlashcard();

        $result = FlashcardHelper::listWithPracticeStatus();
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(__("label.flashcard.practice.status.correct"), $result[0]['Status']);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_listWithPracticeStatus_when_should_return_flashcard_with_incorrect_status()
    {
        FlashcardFixtures::createIncorrectAnsweredFlashcard();

        $result = FlashcardHelper::listWithPracticeStatus();
        $this->assertArrayHasKey(0, $result);
        $this->assertEquals(__("label.flashcard.practice.status.incorrect"), $result[0]['Status']);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_fetchFlashcardForPractice_given_not_exists_question_should_throw_exception()
    {
        $this->expectException(NotFoundException::class);
        FlashcardHelper::fetchFlashcardForPractice(10);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_fetchFlashcardForPractice_given_correct_answered_question_should_throw_exception()
    {

        $this->expectException(PracticeAllowanceException::class);
        $flashcard = FlashcardFixtures::createCorrectAnsweredFlashcard();
        FlashcardHelper::fetchFlashcardForPractice($flashcard->id);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_fetchFlashcardForPractice_given_valid_question_should_fetch_the_flashcard()
    {
        $flashcard = FlashcardFixtures::createIncorrectAnsweredFlashcard();
        $result = FlashcardHelper::fetchFlashcardForPractice($flashcard->id);
        $this->assertEquals(FlashcardFixtures::QUESTION, $result->question);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_answerQuestion_given_correct_answer_should_return_correct()
    {
        $flashcard = FlashcardFixtures::createNotAnsweredFlashcard();
        $result = FlashcardHelper::answerQuestion($flashcard, FlashcardFixtures::ANSWER);
        $this->assertEquals(StatusCodes::CORRECT_STATUS, $result);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_answerQuestion_given_incorrect_answer_should_return_incorrect()
    {
        $flashcard = FlashcardFixtures::createNotAnsweredFlashcard();
        $result = FlashcardHelper::answerQuestion($flashcard, FlashcardFixtures::WRONG_ANSWER);
        $this->assertEquals(StatusCodes::INCORRECT_STATUS, $result);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_flashcardCount_store_2_question_should_return_2()
    {
        FlashcardFixtures::createNotAnsweredFlashcard();
        FlashcardFixtures::createNotAnsweredFlashcard();

        $reflection = new \ReflectionClass(get_class(new FlashcardHelper()));
        $method = $reflection->getMethod("flashcardCount");
        $method->setAccessible(true);
        $count = $method->invokeArgs(new FlashcardHelper(), []);
        $this->assertEquals(2, $count);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_getPercentageOfCompletion_store_2_question_should_return_50_percentage()
    {
        FlashcardFixtures::createNotAnsweredFlashcard();
        FlashcardFixtures::createCorrectAnsweredFlashcard();

        $reflection = new \ReflectionClass(get_class(new FlashcardHelper()));
        $method = $reflection->getMethod("answeredQuestionPercentage");
        $method->setAccessible(true);
        $count = $method->invokeArgs(new FlashcardHelper(), []);
        $this->assertEquals(50, $count);
    }

    /**
     *
     * @return void
     * @throws \Throwable
     */
    public function test_getPercentageOfCompletion_store_2_question_should_return_33_percentage()
    {
        FlashcardFixtures::createNotAnsweredFlashcard();
        FlashcardFixtures::createIncorrectAnsweredFlashcard();
        FlashcardFixtures::createCorrectAnsweredFlashcard();

        $reflection = new \ReflectionClass(get_class(new FlashcardHelper()));
        $method = $reflection->getMethod("getPercentageOfCompletion");
        $method->setAccessible(true);
        $count = $method->invokeArgs(new FlashcardHelper(), []);
        $this->assertEquals(33, $count);
    }


}

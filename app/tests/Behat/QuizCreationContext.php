<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use App\Entity\Answer;
use App\Entity\Quiz;
use App\Service\QuizEngineService;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class QuizCreationContext implements Context
{
    private Quiz $quiz;
    private QuizEngineService $sut;
    private string $player;

    public function __construct(QuizEngineService $sut)
    {
        $this->sut = $sut;
    }

    /**
     * @Then his score must be :score
     */
    public function hisScoreMustBe(int $score)
    {
        Assert::same($score, $this->sut->getPlayerScore($this->quiz->getId(), $this->player));
    }


    /**
     * @When player answer correctly to a question
     */
    public function playerAnswerCorrectlyToAQuestion()
    {
        $nextQuestion = $this->sut->getNextQuestion($this->quiz->getId(), $this->player);
        $correctAnswerId = $nextQuestion->getCorrectAnswerId();
        $answer = new Answer($this->player, $nextQuestion->getId(), $this->quiz->getId(), $correctAnswerId);
        $this->sut->answerToQuestion($answer);
    }


    /**
     * @Then next question must be :index
     */
    public function nextQuestionMustBe(int $index)
    {
        $nextQuestion = $this->sut->getNextQuestion($this->quiz->getId(), $this->player);
        $questionIndex = array_search($nextQuestion, $this->quiz->getQuestions());
        Assert::same($index, $questionIndex);
    }



    /**
     * @Given a player named :player
     */
    public function aPlayerNamed(string $player)
    {
      $this->player = $player;
    }

    /**
     * @When player start a new quiz
     */
    public function playerStartANewQuiz2()
    {
        $this->quiz = $this->sut->createAQuiz($this->player);
    }

    /**
     * @Given player answer wrongly to a question
     */
    public function playerAnswerWronglyToAQuestion()
    {
        $nextQuestion = $this->sut->getNextQuestion($this->quiz->getId(), $this->player);
        $correctAnswerId = $nextQuestion->getCorrectAnswerId();
        $answer = new Answer($this->player, $nextQuestion->getId(), $this->quiz->getId(), $correctAnswerId+1);
        $this->sut->answerToQuestion($answer);
    }
}

<?php

use App\Entity\Answer;
use App\Entity\Question;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

use App\Service\QuizEngineService;
use App\Repository\InMemoryGameRepo;
use App\Repository\InMemoryQuizRepo;
use App\Repository\InMemoryAnswerRepo;
use App\Repository\InMemoryQuestionRepo;

class QuizIntegrationTest extends TestCase
{
    private InMemoryGameRepo $gameRepo;
    private InMemoryQuizRepo $quizRepo;
    private InMemoryAnswerRepo $answerRepo;
    private InMemoryQuestionRepo $questionRepo;
    private QuizEngineService $quizEngine;

    private Session $session;

    protected function setUp(): void
    {
        $questions = [];
        for ($i = 0; $i<10; $i++){
            $question = new Question($i);
            $question->setAvailableAnswers(array("correctAnswer".$i, "wrongAnswer".$i ));
            $question->setCorrectAnswerId(0);
            $questions[] = $question;
        }

        $this->session = new Session(new MockFileSessionStorage());

        $this->quizRepo = new InMemoryQuizRepo($this->session);
        $this->questionRepo = new InMemoryQuestionRepo($questions);
        $this->answerRepo = new InMemoryAnswerRepo($this->session);
        $this->gameRepo = new InMemoryGameRepo($this->session);

        $this->quizEngine = new QuizEngineService(
            $this->quizRepo,
            $this->questionRepo,
            $this->answerRepo,
            $this->gameRepo
        );
    }

    public function test_completeQuiz_allCorrectAnswer(){

        $player = "player1";
        $quiz = $this->quizEngine->createAQuiz($player);
        $quizId = $quiz->getId();

        $nextQuestion = $this->quizEngine->getNextQuestion($quizId, $player);

        while($nextQuestion != null){
            $answer = new Answer($player, $nextQuestion->getId(), $quizId,0);
            $this->quizEngine->answerToQuestion($answer);
            $nextQuestion = $this->quizEngine->getNextQuestion($quizId, $player);
        }

        $score = $this->quizEngine->getPlayerScore($quizId,$player);
        $this->assertEquals(10, $score);
    }

    public function test_completeQuiz_halfCorrectAnswer(){

        $player = "player1";
        $quiz = $this->quizEngine->createAQuiz($player);
        $quizId = $quiz->getId();

        $nextQuestion = $this->quizEngine->getNextQuestion($quizId, $player);

        $index = 0;
        while($nextQuestion != null){
            $answer = new Answer($player, $nextQuestion->getId(), $quizId,$index % 2);
            $index++;
            $this->quizEngine->answerToQuestion($answer);
            $nextQuestion = $this->quizEngine->getNextQuestion($quizId, $player);
        }

        $score = $this->quizEngine->getPlayerScore($quizId,$player);
        $this->assertEquals(5, $score);
    }
}

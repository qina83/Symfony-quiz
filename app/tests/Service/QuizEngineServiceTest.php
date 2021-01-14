<?php


namespace App\Tests\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Service\QuizEngineService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;


class QuizEngineServiceTest extends TestCase
{
    private array $questions;

    private Prophet $prophet;
    private ObjectProphecy $quizRepo;
    private ObjectProphecy $questionRepo;
    private ObjectProphecy $answerRepo;


    private QuizEngineService $sut;


    protected function setUp(): void
    {
        $this->prophet = new Prophet();
        $this->quizRepo = $this->prophet->prophesize("App\Repository\QuizRepoInterface");
        $this->questionRepo = $this->prophet->prophesize("App\Repository\QuestionRepoInterface");
        $this->answerRepo = $this->prophet->prophesize("App\Repository\AnswerRepoInterface");

        $this->questions = [];
        for ($i = 1; $i <= 100; $i++) {
            $this->questions[] = new Question($i);
        }
        $this->questionRepo->loadQuestions()->willReturn($this->questions);
        $this->quizRepo->saveQuiz(Argument::any())->willReturnArgument(0);

        $this->sut = new QuizEngineService(
            $this->quizRepo->reveal(),
            $this->questionRepo->reveal(),
            $this->answerRepo->reveal());
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }

    public function testGetQuiz_QuestionsMustBe10()
    {
        $quiz = $this->sut->createAQuiz();
        $questions = $quiz->getQuestions();

        $this->assertCount(10, $questions);
    }

    public function testGetQuiz_QuestionsMustHaveDistinctIds()
    {
        $quiz = $this->sut->createAQuiz();
        $questions = $quiz->getQuestions();
        $ids = array_map(
            function (Question $q) {
                return $q->getId();
            }, $questions);
        $this->assertSameSize($questions, array_unique($ids));
    }

    public function testCreateAQuiz_MustCallSaveQuiz()
    {
        $this->quizRepo->saveQuiz(Argument::any())->shouldBeCalled();
        $quiz = $this->sut->createAQuiz();
        $this->assertNotNull($quiz);
    }

    public function testAnswer_MustCallSaveAnswer()
    {
        $answer = new Answer("player", 1, 1, 1);
        $this->answerRepo->saveAnswer(Argument::any())->willReturn($answer);
        $question = new Question(1);
        $question->setAvailableAnswers(array(1, 2, 3, 4));
        $this->questionRepo->loadQuestion(Argument::any())->willReturn($question);

        $quiz = new Quiz();
        $quiz->setQuestions(array($question));
        $this->quizRepo->LoadQuiz(Argument::any())->willReturn($quiz);

        $this->answerRepo->saveAnswer(Argument::any())->shouldBeCalled();

        $answer = $this->sut->answerToQuestion($answer);
        $this->assertNotNull($answer);
    }

    public function testAnswer_QuizNotFound_MustThrowException()
    {
        $this->quizRepo->LoadQuiz(Argument::any())->willReturn(null);
        $this->questionRepo->loadQuestion(Argument::any())->willReturn(new Question(1));

        $this->expectExceptionMessage("quiz not found");

        $this->sut->answerToQuestion(new Answer("player", 1, 1, 1));
    }

    public function testAnswer_QuestionIsNotInsideQuiz_MustThrowException()
    {
        $this->quizRepo->LoadQuiz(Argument::any())->willReturn(new Quiz());
        $this->questionRepo->loadQuestion(Argument::any())->willReturn(new Question(1));

        $this->expectExceptionMessage("question not found");

        $this->sut->answerToQuestion(new Answer("player", 1, 1, 1));
    }

    public function testAnswer_AnswerIsNotInsideQuestion_MustThrowException()
    {
        $question = new Question(1);
        $this->questionRepo->loadQuestion(Argument::any())->willReturn($question);

        $quiz = new Quiz();
        $quiz->setQuestions(array($question));
        $this->quizRepo->LoadQuiz(Argument::any())->willReturn($quiz);

        $this->expectExceptionMessage("answer not found");


        $this->sut->answerToQuestion(new Answer("player", 1, 1, 1));
    }

    public function testGetPlayerScore_MustCalculateSumOfCorrectAnswerOfQuiz()
    {
        $answers = [];
        $answers[] = new Answer("player1", 0, 1, 1);
        $answers[] = new Answer("player1", 1, 1, 1);
        $answers[] = new Answer("player1", 2, 1, 1);
        $answers[] = new Answer("player1", 3, 1, 1);
        $answers[] = new Answer("player1", 4, 1, 1);

        $quiz = new Quiz();
        $questions = [];
        $questions[] = new Question(0);
        $questions[] = new Question(1);
        $questions[] = new Question(2);
        $questions[] = new Question(3);
        $questions[] = new Question(4);

        $questions[0]->setCorrectAnswerId(1);
        $questions[1]->setCorrectAnswerId(2);
        $questions[2]->setCorrectAnswerId(3);
        $questions[3]->setCorrectAnswerId(4);
        $questions[4]->setCorrectAnswerId(1);

        $quiz->setQuestions($questions);

        $this->answerRepo->getAnswersByQuizAndPlayer(Argument::any(), Argument::any())->willReturn($answers);
        $this->quizRepo->loadQuiz(Argument::any())->willReturn($quiz);

        $score = $this->sut->getPlayerScore(1, "player");
        $this->assertEquals(2, $score);

    }

    public function testGetPlayerScore_UserHasZeroAnswer_MustReturnZero()
    {
        $answers = [];
        $quiz = new Quiz();

        $this->answerRepo->getAnswersByQuizAndPlayer(Argument::any(), Argument::any())->willReturn($answers);
        $this->quizRepo->loadQuiz(Argument::any())->willReturn($quiz);

        $score = $this->sut->getPlayerScore(1, "player");
        $this->assertEquals(0, $score);
    }

    public function testGetPlayerScore_QuizNotExists_MustThrowException()
    {
        $this->quizRepo->loadQuiz(Argument::any())->willReturn(null);
        $this->expectException(\InvalidArgumentException::class);

        $this->sut->getPlayerScore(1, "player");
    }


}
<?php


namespace App\Service;


use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\AnswerRepoInterface;
use App\Repository\GameRepoInterface;
use App\Repository\QuestionRepoInterface;
use App\Repository\QuizRepoInterface;

class QuizEngineService implements QuizEngineServiceInterface
{

    private QuizRepoInterface $quizRepo;
    private QuestionRepoInterface $questionRepo;
    private AnswerRepoInterface $answerRepo;
    private GameRepoInterface $gameRepo;

    /**
     * QuizEngineService constructor.
     * @param QuizRepoInterface $quizRepo
     * @param QuestionRepoInterface $questionRepo
     * @param AnswerRepoInterface $answerRepo
     * @param GameRepoInterface $gameRepo
     */
    public function __construct(QuizRepoInterface $quizRepo,
                                QuestionRepoInterface $questionRepo,
                                AnswerRepoInterface $answerRepo,
                                GameRepoInterface $gameRepo)
    {
        $this->quizRepo = $quizRepo;
        $this->questionRepo = $questionRepo;
        $this->answerRepo = $answerRepo;
        $this->gameRepo = $gameRepo;
    }


    public function createAQuiz(string $player): Quiz
    {
        $quiz = new Quiz();
        $quiz->setId(1);

        $allQuestions = $this->questionRepo->loadQuestions();
        $selectedQuestions = array_intersect_key($allQuestions, array_flip(array_rand($allQuestions, 10)));
        $questionList = [];
        foreach ($selectedQuestions as &$q) {
            $questionList[] = $q;
        }

        /*$selectedQuestions =
            array_intersect_key(
                $allQuestions, array_flip()
            );*/
        $quiz->setQuestions($questionList);
        $this->gameRepo->savePlayerCurrentQuestionIndex($quiz->getId(), $player, 0);
        return $this->quizRepo->saveQuiz($quiz);
    }

    public function answerToQuestion(Answer $answer): Answer
    {
        $quiz = $this->quizRepo->loadQuiz($answer->getQuizId());
        if ($quiz == null) throw new \InvalidArgumentException("quiz not found");

        $question = $quiz->getQuestionById($answer->getQuestionId());

        if ($question == null) throw new \InvalidArgumentException("question not found");
        if (!array_key_exists($answer->getAnswerId(), $question->getAvailableAnswers())) throw new \InvalidArgumentException("answer not found");

        $lastQuestionIndex = $this->gameRepo->loadPlayerCurrentQuestionIndex($answer->getQuizId(), $answer->getPlayer());
        $this->gameRepo->savePlayerCurrentQuestionIndex($answer->getQuizId(), $answer->getPlayer(), $lastQuestionIndex + 1);
        return $this->answerRepo->saveAnswer($answer);
    }

    public function getPlayerScore(int $quizId, string $player): int
    {
        $score = 0;
        $quiz = $this->quizRepo->loadQuiz($quizId);
        if ($quiz == null) throw new \InvalidArgumentException("quiz not found");
        $answers = $this->answerRepo->getAnswersByQuizAndPlayer($quizId, $player);
        foreach ($answers as &$answer) {
            $qId = $answer->getQuestionId();
            $aId = $answer->getAnswerId();
            $question = $quiz->getQuestionById($qId);
            if ($question != null) // it shouldn't happen
            {
                if ($question->getCorrectAnswerId() == $aId) {
                    $score++;
                }
            }
        }

        return $score;
    }

    public function getNextQuestion(int $quizId, string $player): ?Question
    {
        $nextIndex = $this->gameRepo->loadPlayerCurrentQuestionIndex($quizId, $player);
        $quiz = $this->quizRepo->loadQuiz($quizId);
        return $quiz->getQuestionByIndex($nextIndex);
    }
}
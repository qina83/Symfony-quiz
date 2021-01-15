<?php


namespace App\Service;


use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;
use App\Repository\AnswerRepoInterface;
use App\Repository\QuestionRepoInterface;
use App\Repository\QuizRepoInterface;

class QuizEngineService implements QuizEngineServiceInterface
{

    private QuizRepoInterface $quizRepo;
    private QuestionRepoInterface $questionRepo;
    private AnswerRepoInterface $answerRepo;

    /**
     * QuizEngineService constructor.
     * @param QuizRepoInterface $quizRepo
     * @param QuestionRepoInterface $questionRepo
     * @param AnswerRepoInterface $answerRepo
     */
    public function __construct(QuizRepoInterface $quizRepo, QuestionRepoInterface $questionRepo, AnswerRepoInterface $answerRepo)
    {
        $this->quizRepo = $quizRepo;
        $this->questionRepo = $questionRepo;
        $this->answerRepo = $answerRepo;
    }


    public function createAQuiz(): Quiz
    {
        $quiz = new Quiz();
        $allQuestions = $this->questionRepo->loadQuestions();
        $selectedQuestions =
            array_intersect_key(
                $allQuestions, array_flip(array_rand($allQuestions, 10))
            );
        $quiz->setQuestions($selectedQuestions);
        $this->quizRepo->saveQuiz($quiz);
        return $quiz;
    }

    public function answerToQuestion(Answer $answer): Answer
    {
        $quiz = $this->quizRepo->loadQuiz($answer->getQuizId());
        if ($quiz == null) throw new \InvalidArgumentException("quiz not found");

        $question = $quiz->getQuestionById($answer->getQuestionId());

        if ($question == null) throw new \InvalidArgumentException("question not found");
        if (!array_key_exists($answer->getAnswerId(), $question->getAvailableAnswers())) throw new \InvalidArgumentException("answer not found");

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
                if ($question->getCorrectAnswerId() == $aId)
                {
                    $score++;
                }
            }
        }

        return $score;
    }
}
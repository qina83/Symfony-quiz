<?php


namespace App\Repository;


use App\Entity\Quiz;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InMemoryQuizRepo implements QuizRepoInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function saveQuiz(Quiz $quiz): Quiz
    {
        $this->session->set("quiz", $quiz);
        return $quiz;
    }

    public function loadQuiz(int $id): ?Quiz
    {
        return $this->session->get("quiz");
    }
}
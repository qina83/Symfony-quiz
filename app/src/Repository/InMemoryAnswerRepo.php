<?php


namespace App\Repository;


use App\Entity\Answer;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InMemoryAnswerRepo implements AnswerRepoInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function saveAnswer(Answer $answer): Answer
    {
        $answers = $this->session->get("answers", []);
        $answers[] = $answer;
        $this->session->set("answers", $answers);
        return $answer;
    }

    public function getAnswersByQuizAndPlayer(int $quizId, string $player): array
    {
        $answers = $this->session->get("answers", []);
        return array_filter($answers, function (Answer $answer) use ($quizId, $player) {
            return $answer->getPlayer() == $player && $answer->getQuizId() == $quizId;
        });
    }
}
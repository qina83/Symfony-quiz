<?php


namespace App\Repository;


use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InMemoryGameRepo implements GameRepoInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function savePlayerCurrentQuestionIndex(int $idQuiz, string $player, int $questionId)
    {
        $this->session->set($idQuiz . $player, $questionId);
    }

    public function loadPlayerCurrentQuestionIndex(int $idQuiz, string $player): int
    {
        return $this->session->get($idQuiz . $player, 0);
    }
}
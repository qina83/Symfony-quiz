<?php


namespace App\Repository;

interface GameRepoInterface
{
    public function savePlayerCurrentQuestionIndex(int $idQuiz, string $player, int $questionId);
    public function loadPlayerCurrentQuestionIndex(int $idQuiz, string $player): int;
}
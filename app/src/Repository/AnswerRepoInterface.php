<?php


namespace App\Repository;


use App\Entity\Answer;

interface AnswerRepoInterface
{
    public function saveAnswer(Answer $answer): Answer;
    public function getAnswersByQuizAndPlayer(int $quizId, string $player): array;
}
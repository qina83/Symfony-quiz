<?php


namespace App\Service;

use App\Entity\Answer;
use App\Entity\Quiz;

interface QuizEngineServiceInterface
{
    public function createAQuiz():Quiz;
    public function answerToQuestion(Answer $answer);
    public function getPlayerScore(int $quizId, string $player);
}
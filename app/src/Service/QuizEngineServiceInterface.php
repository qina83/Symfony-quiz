<?php


namespace App\Service;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\Quiz;

interface QuizEngineServiceInterface
{
    public function createAQuiz(string $player): Quiz;
    public function answerToQuestion(Answer $answer);
    public function getPlayerScore(int $quizId, string $player);
    public function getNextQuestion(int $quizId, string $player): ?Question;
}
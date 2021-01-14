<?php


namespace App\Repository;
use App\Entity\Quiz;

interface QuizRepoInterface
{
    public function saveQuiz(Quiz $quiz): Quiz;
    public function loadQuiz(int $id): ?Quiz;

}
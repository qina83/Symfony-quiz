<?php


namespace App\Repository;


use App\Entity\Question;

interface QuestionRepoInterface
{
    public function loadQuestions(): array;
    public function loadQuestion(int $id): Question;
}
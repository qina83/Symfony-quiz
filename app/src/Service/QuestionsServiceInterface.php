<?php


namespace App\Service;


use App\Entity\Question;

interface QuestionsServiceInterface
{
    public function getQuestions(): array;
    public function addQuestion(Question $question): Question;
    public function deleteQuestion(int $id);
    public function updateQuestion(Question $question): Question;
}
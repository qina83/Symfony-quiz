<?php


namespace App\Repository;

use App\Entity\Question;

class InMemoryQuestionRepo implements QuestionRepoInterface
{
    private array $questions = [];

    public function __construct(?array $questions = null){
        if ($questions != null) $this->questions = $questions;
        else
        for ($i = 0; $i<100; $i++){
            $question = new Question($i);
            $question->setAvailableAnswers(array("correctAnswer".$i, "wrongAnswer".$i ));
            $question->setCorrectAnswerId(0);
            $questions[] = $question;
        }
    }

    public function loadQuestions(): array
    {
        return $this->questions;
    }

}
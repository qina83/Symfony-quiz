<?php


namespace App\Entity;


class Quiz
{
    private ?int $id = null;
    private array $questions = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param array $questions
     */
    public function setQuestions(array $questions): void
    {
        $this->questions = $questions;
    }

    public function getQuestionById(int $id): ?Question{
        for($i = 0; $i<count($this->questions); $i++){
            if ($this->questions[$i]->getId() == $id) return $this->questions[$i];
        }
        return null;
    }

    public function getQuestionByIndex(int $index): ?Question{
        if (isset($this->questions[$index])) return $this->questions[$index];
        else return null;
    }

}
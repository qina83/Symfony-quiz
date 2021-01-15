<?php


namespace App\Entity;


class Question
{
    private ?int $id = null;
    private string $question;
    private array $availableAnswers = [];
    //private int $topicId;
    private int $correctAnswerId;

    /**
     * Question constructor.
     * @param int|null $id
     * @param string $question
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    /*public function getTopicId(): int
    {
        return $this->topicId;
    }*/

    /**
     * @param int $topicId
     */
  /*  public function setTopicId(int $topicId): void
    {
        $this->topicId = $topicId;
    }*/

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
     * @return string
     */
    public function getQuestion(): string
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    /**
     * @return array
     */
    public function getAvailableAnswers(): array
    {
        return $this->availableAnswers;
    }

    /**
     * @param array $availableAnswers
     */
    public function setAvailableAnswers(array $availableAnswers): void
    {
        $this->availableAnswers = $availableAnswers;
    }

    /**
     * @return int
     */
    public function getCorrectAnswerId(): int
    {
        return $this->correctAnswerId;
    }

    /**
     * @param int $correctAnswerId
     */
    public function setCorrectAnswerId(int $correctAnswerId): void
    {
        $this->correctAnswerId = $correctAnswerId;
    }


}
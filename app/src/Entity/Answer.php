<?php


namespace App\Entity;


class Answer
{
    private ?int $id = null;

    private string $player;
    private int $questionId;
    private int $quizId;
    private int $answerId;

    /**
     * Answer constructor.
     * @param string $player
     * @param int $questionId
     * @param int $quizId
     * @param int $answerId
     */
    public function __construct(string $player, int $questionId, int $quizId, int $answerId)
    {
        $this->player = $player;
        $this->questionId = $questionId;
        $this->quizId = $quizId;
        $this->answerId = $answerId;
    }

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
     * @return int
     */
    public function getQuizId(): int
    {
        return $this->quizId;
    }

    /**
     * @param int $quizId
     */
    public function setQuizId(int $quizId): void
    {
        $this->quizId = $quizId;
    }

    /**
     * @return string
     */
    public function getPlayer(): string
    {
        return $this->player;
    }

    /**
     * @param string $player
     */
    public function setPlayer(string $player): void
    {
        $this->player = $player;
    }

    /**
     * @return int
     */
    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    /**
     * @param int $questionId
     */
    public function setQuestionId(int $questionId): void
    {
        $this->questionId = $questionId;
    }

    /**
     * @return int
     */
    public function getAnswerId(): int
    {
        return $this->answerId;
    }

    /**
     * @param int $answerId
     */
    public function setAnswerId(int $answerId): void
    {
        $this->answerId = $answerId;
    }
}
<?php

namespace App\Tests\Repository;

use App\Entity\Answer;
use App\Repository\InMemoryAnswerRepo;
use Symfony\Component\HttpFoundation\Session\Session;

class InMemoryAnswerRepoTest extends InMemoryBaseTest
{
    private InMemoryAnswerRepo $rut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rut = new InMemoryAnswerRepo($this->session);
    }

    public function testSaveAnswer()
    {
        $answer = new Answer("player1", 1,1,1);

        $this->rut->saveAnswer($answer);
        $answers = $this->session->get("answers", []);

        $this->assertCount(1,$answers) ;
        $this->assertEquals("player1", $answers[0]->getPlayer());
    }

    public function testGetAnswersByQuizAndPlayer_NoAnswers_MustReturnEmptyArray(){
        $answers = $this->rut->getAnswersByQuizAndPlayer(1, "player1");

        $this->assertEmpty($answers);
    }

    public function testGetAnswersByQuizAndPlayer_NoAnswersForQuiz_MustReturnEmptyArray(){
        $answer = new Answer("player1", 1,1,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answers = $this->rut->getAnswersByQuizAndPlayer(2, "player1");

        $this->assertEmpty($answers);
    }


    public function testGetAnswersByQuizAndPlayer_NoAnswersForPlayerMustReturnEmptyArray(){
        $answer = new Answer("player1", 1,1,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answers = $this->rut->getAnswersByQuizAndPlayer(1, "player2");

        $this->assertEmpty($answers);
    }

    public function testGetAnswersByQuizAndPlayer_MustReturnAnswerOnlyForPlayerAndQuiz(){
        $answer = new Answer("player1", 1,1,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answer = new Answer("player1", 1,2,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answer = new Answer("player2", 1,1,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answer = new Answer("player2", 1,2,1);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);
        $this->rut->saveAnswer($answer);

        $answers = $this->rut->getAnswersByQuizAndPlayer(2, "player1");

        $this->assertCount(3, $answers);
    }
}

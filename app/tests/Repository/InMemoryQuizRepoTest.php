<?php

namespace App\Tests\Repository;

use App\Entity\Quiz;
use App\Repository\InMemoryQuizRepo;
use App\Tests\Repository\InMemoryBaseTest;
use Symfony\Component\HttpFoundation\Session\Session;

class InMemoryQuizRepoTest extends InMemoryBaseTest
{
    private InMemoryQuizRepo $rut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rut = new InMemoryQuizRepo($this->session);
    }

    public function testSaveQuiz()
    {
        $quiz = new Quiz();
        $quiz->setId(1);

        $this->rut->saveQuiz($quiz);

        $storedQuiz = $this->session->get("quiz");

        $this->assertEquals($quiz->getId(), $storedQuiz->getId());
    }

    public function testLoadQuiz()
    {
        $quiz = new Quiz();
        $quiz->setId(2);
        $this->session->set("quiz", $quiz);
        $storedQuiz = $this->rut->loadQuiz(1);
        $this->assertEquals($quiz->getId(), $storedQuiz->getId());
    }


}

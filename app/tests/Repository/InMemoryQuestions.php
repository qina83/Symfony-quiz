<?php

namespace App\Tests\Repository;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\InMemoryQuestionRepo;
use Symfony\Component\HttpFoundation\Session\Session;
use Webmozart\Assert\Assert;

class InMemoryQuestionRepoTest extends InMemoryBaseTest
{
    private InMemoryQuestionRepo $rut;

    public function testLoadQuestion()
    {
        $this->rut = new InMemoryQuestionRepo();
        $questions = $this->rut->loadQuestions();
        $this->assertCount(100, $questions);
    }

    public function testLoadQuestion_ForceQuestion()
    {
        $questions = [];
        $questions[] = new Question(1);
        $questions[] = new Question(2);
        $questions[] = new Question(3);
        $this->rut = new InMemoryQuestionRepo($questions);

        $questions = $this->rut->loadQuestions();
        $this->assertEquals($questions, $this->rut->loadQuestions());
    }
}

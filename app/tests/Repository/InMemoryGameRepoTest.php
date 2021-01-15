<?php

namespace App\Tests\Repository;

use App\Repository\InMemoryGameRepo;

class InMemoryGameRepoTest extends InMemoryBaseTest
{
    private InMemoryGameRepo $rut;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rut = new InMemoryGameRepo($this->session);
    }

    public function testSavePlayerCurrentQuestionIndex()
    {
        $this->rut->savePlayerCurrentQuestionIndex(1, "Player", 1);
        $nextQuestion =  $this->session->get("1Player", 0);

        $this->assertEquals(1, $nextQuestion);
    }

    public function testLoadPlayerCurrentQuestionIndex()
    {
        $this->session->set("1Player", 5);
        $nextQuestion =  $this->rut->loadPlayerCurrentQuestionIndex(1, "Player");

        $this->assertEquals(5, $nextQuestion);
    }
}

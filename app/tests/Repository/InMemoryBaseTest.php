<?php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

abstract class InMemoryBaseTest extends TestCase
{
    protected Session $session;

    protected function setUp(): void
    {
        $this->session = new Session(new MockFileSessionStorage());
    }
}

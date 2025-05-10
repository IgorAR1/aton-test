<?php

namespace Unit;

use App\Core\Event\EventDispatcher;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

final class FileCacheTest extends TestCase
{
    public function testWriteWithDirectory(): void
    {
        $this->assertTrue(true);
    }
    public function testWriteWithoutDirectory(): void
    {
        $this->assertTrue(true);
    }
}
<?php

namespace OCA\News\Tests\Unit\Log;

use OCA\News\Log\FeedIoLogger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FeedIoLoggerTest extends TestCase
{
    public function testDowngradesSpecificError(): void
    {
        /** @var LoggerInterface|MockObject $inner */
        $inner = $this->createMock(LoggerInterface::class);

        $inner->expects($this->never())
            ->method('error');
        $inner->expects($this->once())
            ->method('debug')
            ->with('No parser can handle this stream', []);

        $logger = new FeedIoLogger($inner);
        $logger->error('No parser can handle this stream');
    }

    public function testPassesOtherMessages(): void
    {
        /** @var LoggerInterface|MockObject $inner */
        $inner = $this->createMock(LoggerInterface::class);

        $inner->expects($this->once())
            ->method('error')
            ->with('Something else', []);

        $logger = new FeedIoLogger($inner);
        $logger->error('Something else');
    }
}

<?php
namespace OCA\News\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Logger wrapper for feed-io to silence noisy messages.
 */
class FeedIoLogger extends AbstractLogger
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = []): void
    {
        if ($level === LogLevel::ERROR && $message === 'No parser can handle this stream') {
            $this->logger->debug($message, $context);
            return;
        }

        $this->logger->log($level, $message, $context);
    }
}

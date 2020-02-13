<?php
/**
 * 05.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\Service;

use Psr\Log\LoggerInterface;
use Sentry\Event;
use srr\SentryFilteredBundle\DependencyInjection\Configuration;

class SentryErrorFilter
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var array|string[]
     */
    private array $filteredExceptions;

    /**
     * SentryErrorFilter constructor.
     * @param LoggerInterface $logger
     * @param array           $filteredExceptions
     */
    public function __construct(LoggerInterface $logger, array $filteredExceptions = [])
    {
        $this->logger = $logger;
        $this->filteredExceptions = $filteredExceptions;
    }

    public function __invoke(Event $event): ?Event
    {
        foreach ($event->getExceptions() as $exception) {
            if ($this->checkException($exception['type'])) {
                return $event;
            }
        }

        return null;
    }

    private function checkException(string $type): bool
    {
        if (empty($this->filteredExceptions)) {
            $this->logger->warning(\sprintf('Parameters `%s` for sentry filter is empty.', Configuration::FILTERED_EXCEPTIONS));
            return true;
        }

        foreach ($this->filteredExceptions as $exception) {
            if (\is_a($type, $exception, true)) {
                return true;
            }
        }

        return false;
    }
}

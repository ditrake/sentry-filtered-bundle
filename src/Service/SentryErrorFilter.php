<?php
/**
 * 05.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\Service;

use Psr\Log\LoggerInterface;
use srr\SentryFilteredBundle\Exception\SentryFilterException;
use Sentry\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SentryErrorFilter
{
    /** @var string  */
    public const CONFIGURATION_ROOT = 'sentry_filtered';

    /** @var string  */
    public const FILTERED_EXCEPTIONS = 'filtered_exceptions';

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * SentryErrorFilter constructor.
     * @param ContainerInterface $container
     * @param LoggerInterface    $logger
     */
    public function __construct(ContainerInterface $container, LoggerInterface $logger)
    {
        $this->container = $container;
        $this->logger = $logger;
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
        if (!$this->container->hasParameter(self::CONFIGURATION_ROOT)) {
            throw new SentryFilterException(\sprintf('Parameters \'%s\' for sentry filter not configured', self::CONFIGURATION_ROOT));
        }

        $parameters = $this->container->getParameter(self::CONFIGURATION_ROOT);
        if (!isset($parameters[self::FILTERED_EXCEPTIONS]) || !is_array($parameters[self::FILTERED_EXCEPTIONS])) {
            throw new SentryFilterException(\sprintf('Parameters \'%s\' for sentry filter not configured', self::FILTERED_EXCEPTIONS));
        }

        if (empty($parameters[self::FILTERED_EXCEPTIONS])) {
            $this->logger->warning(\sprintf('Parameters `%s` for sentry filter is empty.', self::FILTERED_EXCEPTIONS));
            return true;
        }

        foreach ($parameters[self::FILTERED_EXCEPTIONS] as $exception) {
            if (\is_a($type, $exception, true)) {
                return true;
            }
        }

        return false;
    }
}

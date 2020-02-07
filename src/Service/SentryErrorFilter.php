<?php
/**
 * 05.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\Service;

use srr\SentryFilteredBundle\Exception\SentryFilterException;
use Sentry\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SentryErrorFilter
{
    /** @var string  */
    private const ROOT_PARAMETERS = 'sentry';

    /** @var string  */
    private const ENTRY_PARAMS = 'report_errors';

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    /**
     * SentryErrorFilter constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
        if (!$this->container->hasParameter(self::ROOT_PARAMETERS)) {
            throw new SentryFilterException(\sprintf('Parameters \'%s\' for sentry filter not configured', self::ROOT_PARAMETERS));
        }

        $parameters = $this->container->getParameter('sentry');
        if (!isset($parameters[self::ENTRY_PARAMS]) || empty($parameters[self::ENTRY_PARAMS]) || !is_array($parameters[self::ENTRY_PARAMS])) {
            throw new SentryFilterException(\sprintf('Parameters \'%s\' for sentry filter not configured', self::ENTRY_PARAMS));
        }

        foreach ($parameters[self::ENTRY_PARAMS] as $exception) {
            if (\is_a($type, $exception, true)) {
                return true;
            }
        }

        return false;
    }
}

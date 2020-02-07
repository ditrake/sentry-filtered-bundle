<?php
/**
 * 07.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @var string  */
    public const CONFIGURATION_ROOT = 'sentry_filtered';

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::CONFIGURATION_ROOT);
    }
}
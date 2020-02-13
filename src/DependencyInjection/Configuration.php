<?php
/**
 * 07.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /** @var string  */
    public const CONFIGURATION_ROOT = 'sentry_filtered';

    /** @var string  */
    public const FILTERED_EXCEPTIONS = 'filtered_exceptions';


    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::CONFIGURATION_ROOT);

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = \method_exists(TreeBuilder::class, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root(self::CONFIGURATION_ROOT);
        $rootNode->children()
            ->arrayNode(self::FILTERED_EXCEPTIONS)
            ->scalarPrototype()->end()
            ->end();
        return $treeBuilder;
    }
}
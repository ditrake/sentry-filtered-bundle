<?php
/**
 * 07.02.2020.
 */

declare(strict_types=1);

namespace srr\SentryFilteredBundle\DependencyInjection;

use srr\SentryFilteredBundle\Service\SentryErrorFilter;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{


    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(SentryErrorFilter::CONFIGURATION_ROOT);

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = \method_exists(TreeBuilder::class, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root(SentryErrorFilter::CONFIGURATION_ROOT);
        $rootNode->children()
            ->arrayNode(SentryErrorFilter::FILTERED_EXCEPTIONS)
            ->defaultValue([])
            ->prototype('scalar');

        return $treeBuilder;
    }
}
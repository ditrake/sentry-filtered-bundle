<?php
/**
 * 07.02.2020.
 */

declare(strict_types=1);


namespace srr\SentryFilteredBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SentryFilteredExtension extends Extension
{

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
        $definition = $container->getDefinition('srr_sentry_filtered');
        $definition->setArgument('$filteredExceptions',$config[Configuration::FILTERED_EXCEPTIONS]);

    }
}
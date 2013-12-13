<?php

namespace Toa\Bundle\SimonSaysBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ToaSimonSaysExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $collectorDefinition = new Definition(
            '%toa_simon_says.data_collector.class%',
            array(
                $config['catalogues']
            )
        );

        $collectorDefinition->addTag(
            'data_collector',
            array(
                'template' => 'ToaSimonSaysBundle:Collector:saying',
                'id' => 'saying'
            )
        );

        $container->setDefinition('toa_simon_says.data_collector', $collectorDefinition);
    }
}

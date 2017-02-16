<?php

/*
 * This file is part of the zibios/wrike-bundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Zibios\WrikePhpLibrary\Api;

/**
 * Extension.
 */
class ZibiosWrikeExtension extends Extension
{
    /**
     * Loads the Wrike configuration.
     *
     * @param array            $configs   An array of configuration settings
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        /** @var ConfigurationInterface $configuration */
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);
        $config = (array) $config;

        $container->setParameter('zibios_wrike', $config);
        foreach ($config as $key => $value) {
            $container->setParameter(sprintf('zibios_wrike.%s', $key), $value);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->addPermanentTokenAppDefinitions($config, $container);
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * @throws \BadMethodCallException When the extension name does not follow conventions
     *
     * @return string The alias
     */
    public function getAlias()
    {
        return 'zibios_wrike';
    }

    /**
     * @param $config
     * @param ContainerBuilder $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    protected function addPermanentTokenAppDefinitions($config, ContainerBuilder $container)
    {
        if (isset($config['permanent_tokens']['tokens']) && is_array($config['permanent_tokens']['tokens'])) {
            /** @var array $tokens */
            $tokens = $config['permanent_tokens']['tokens'];
            foreach ($tokens as $tokenName => $tokenCode) {
                $serviceId = sprintf('zibios_wrike.app.%s', strtolower($tokenName));

                $definition = new Definition(Api::class);
                $definition->setFactory(
                    [
                        new Reference('zibios_wrike.api_factory'),
                        'createForPermanentToken',
                    ]
                );
                $definition->addArgument($tokenCode);

                $container->setDefinition($serviceId, $definition);
            }
        }
    }
}

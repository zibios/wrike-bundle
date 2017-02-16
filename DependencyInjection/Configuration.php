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

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * Possible handler types and related configurations (brackets indicate optional params):
 *
 * - api_url:                                OPTIONAL, DEFAULT 'https://www.wrike.com/api/v3/'
 * - permanent_tokens:                       OPTIONAL, DEFAULT []
 *      firstTokenName: firstTokenCode
 *      secondTokenName: secondTokenCode
 */
class Configuration implements ConfigurationInterface
{
    const DEFAULT_NAME = 'default';

    /**
     * Generates the configuration tree builder.
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('zibios_wrike');
        $rootNode
            ->beforeNormalization()
                ->always(
                    function ($v) {
                        return (array) $v;
                    }
                )
            ->end();

        $this->addDefaultsNode($rootNode);
        $this->addPermanentTokensNode($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function addDefaultsNode(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->scalarNode('api_url')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
    }

    /**
     * @param ArrayNodeDefinition $node
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function addPermanentTokensNode(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('permanent_tokens')
                    ->validate()
                        ->ifTrue(function ($v) {
                            return
                                array_key_exists('default_token', $v) &&
                                (
                                    array_key_exists('tokens', $v) === false ||
                                    (
                                        array_key_exists('tokens', $v) === true &&
                                        array_key_exists($v['default_token'], $v['tokens']) === false
                                    )
                                );
                        })
                        ->thenInvalid('Default token not found in tokens array.')
                    ->end()
                    ->children()
                        ->scalarNode('default_token')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                    ->fixXmlConfig('token')
                    ->children()
                        ->arrayNode('tokens')
                            ->validate()
                                ->ifTrue(function ($v) {
                                    /* @var array $v*/
                                    foreach ($v as $key => $value) {
                                        if (is_string($key) && strlen($key) > 0) {
                                            continue;
                                        }

                                        return true;
                                    }

                                    return false;
                                })
                                ->thenInvalid('The token name should be none empty string.')
                            ->end()
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                            ->prototype('scalar')
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}

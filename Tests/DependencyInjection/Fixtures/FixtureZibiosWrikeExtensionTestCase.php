<?php
/**
 * This file is part of the WrikeBundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\Tests\DependencyInjection\Fixtures;

use Zibios\Bundle\WrikeBundle\DependencyInjection\ZibiosWrikeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zibios\Bundle\WrikeBundle\Tests\TestCase;

/**
 * Fixture ZibiosWrikeExtension Test Case
 */
abstract class FixtureZibiosWrikeExtensionTestCase extends TestCase
{
    public function testEmptyConfig()
    {
        $container = $this->getContainer('empty');

        self::assertFalse($container->hasParameter('zibios_wrike'), json_encode($container->getParameterBag()));
    }

    public function testDefaultConfig()
    {
        $container = $this->getContainer('default');

        $expectedConfiguration = [];
        self::assertTrue($container->hasParameter('zibios_wrike'), json_encode($container->getParameterBag()));
        self::assertEquals($expectedConfiguration, $container->getParameter('zibios_wrike'));
    }

    public function testBaseConfig()
    {
        $container = $this->getContainer('base');

        $expectedConfiguration = [
            'permanent_tokens' => [
                'tokens' => [
                    'first' => 'firstToken',
                    'second' => 'secondToken',
                ],
                'default_token' => 'first',
            ],
            'api_url' => 'http://urlApi',
        ];
        self::assertTrue($container->hasParameter('zibios_wrike'), json_encode($container->getParameterBag()));
        self::assertEquals($expectedConfiguration, $container->getParameter('zibios_wrike'));
    }

    public function testLoadWithOverwriting()
    {
        $container = $this->getContainer('overwriting');

        $expectedConfiguration = [
            'permanent_tokens' => [
                'tokens' => [
                    'first' => 'firstToken',
                    'second' => 'secondToken',
                    'third' => 'thirdToken',
                ],
                'default_token' => 'third',
            ],
            'api_url' => 'https://urlOverwritten',
        ];
        self::assertTrue($container->hasParameter('zibios_wrike'));
        self::assertEquals($expectedConfiguration, $container->getParameter('zibios_wrike'));
    }

    /**
     * @param string $fixture
     *
     * @return ContainerBuilder
     */
    protected function getContainer($fixture)
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new ZibiosWrikeExtension());
        $this->loadFixture($container, $fixture);
        $container->compile();

        return $container;
    }

    /**
     * @param ContainerBuilder $container
     * @param string $fixture
     */
    abstract protected function loadFixture(ContainerBuilder $container, $fixture);
}

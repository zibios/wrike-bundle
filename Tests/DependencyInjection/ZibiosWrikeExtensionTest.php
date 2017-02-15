<?php
/**
 * This file is part of the WrikeBundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\Tests\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zibios\Bundle\WrikeBundle\Api\Factory;
use Zibios\Bundle\WrikeBundle\DependencyInjection\ZibiosWrikeExtension;
use Zibios\WrikePhpLibrary\Api;

/**
 * ZibiosWrikeExtensionTest
 */
class ZibiosWrikeExtensionTest extends DependencyInjectionTestCase
{
    /**
     * Some basic tests to make sure the configuration is correctly processed in the standard case.
     *
     * @param array $sourceConfig
     * @param array $expectedConfig
     * @param $expectedExceptionClass
     *
     * @dataProvider configurationProvider
     */
    public function test_processConfig(array $sourceConfig, array $expectedConfig, $expectedExceptionClass)
    {
        $exceptionOccurred = false;
        $exceptionClass = '';
        $exceptionMessage = '';
        $calculatedConfig = [];
        try {
            $container = $this->getContainer(
                [
                    $sourceConfig
                ]
            );

            $calculatedConfig = $container->getParameter('zibios_wrike');
        } catch (\Exception $e) {
            $exceptionOccurred = true;
            $exceptionClass = get_class($e);
            $exceptionMessage = $e->getMessage();
        }

        if ($expectedExceptionClass !== false) {
            self::assertTrue(
                $exceptionOccurred,
                sprintf(
                    '"%s" exception should occurred for "%s".',
                    $expectedExceptionClass,
                    json_encode($sourceConfig)
                )
            );
        }

        if ($expectedExceptionClass === false) {
            self::assertFalse(
                $exceptionOccurred,
                sprintf(
                    '"%s" exception occurred but should not for "%s". Message "%s"',
                    $exceptionClass,
                    json_encode($sourceConfig),
                    $exceptionMessage
                )
            );
            $this->assertEquals($expectedConfig, $calculatedConfig);
        }
    }

    public function test_services()
    {
        $sourceConfiguration = [
            'permanent_tokens' => [
                'default_token' => 'firstName',
                'tokens' => [
                    'firstName' => 'firstToken',
                    'secondName' => 'secondToken',
                    'thirdName' => 'thirdToken',
                ]
            ]
        ];

        $container = $this->getContainer([$sourceConfiguration]);
        self::assertEquals(
            Factory::class,
            $container->getParameter('zibios_wrike.api_factory.class')
        );
        $apiFactory = $container->get('zibios_wrike.api_factory');
        self::assertInstanceOf(Factory::class, $apiFactory);

        self::assertEquals(
            Api::class,
            $container->getParameter('zibios_wrike.api.class')
        );
        $apiFactory = $container->get('zibios_wrike.api');
        self::assertInstanceOf(Api::class, $apiFactory);

        /** @var array $tokens */
        $tokens = $sourceConfiguration['permanent_tokens']['tokens'];
        foreach ($tokens as $tokenName => $tokenCode) {
            $serviceId = sprintf('zibios_wrike.app.%s', strtolower($tokenName));
            self::assertTrue($container->hasDefinition($serviceId));
            self::assertInstanceOf(Api::class, $container->get($serviceId));
            self::assertEquals($tokenCode, $container->get($serviceId)->getBearerToken());
        }

        $serviceIds = array_keys($container->getDefinitions());
        $expectedServiceIds = [
            'zibios_wrike.api_factory',
            'zibios_wrike.api',
            'zibios_wrike.app.firstname',
            'zibios_wrike.app.secondname',
            'zibios_wrike.app.thirdname',
        ];
        self::assertEquals($expectedServiceIds, $serviceIds);
    }

    /**
     * @param array $config
     *
     * @return ContainerBuilder
     */
    protected function getContainer(array $config = [])
    {
        $container = new ContainerBuilder();
        $loader = new ZibiosWrikeExtension();
        $loader->load($config, $container);
        $container->compile();

        return $container;
    }
}

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

use Zibios\Bundle\WrikeBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

/**
 * ConfigurationTest
 */
class ConfigurationTest extends DependencyInjectionTestCase
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
    public function testProcessConfig(array $sourceConfig, array $expectedConfig, $expectedExceptionClass)
    {
        $processor = new Processor();

        $exceptionOccurred = false;
        $exceptionClass = '';
        $exceptionMessage = '';
        $calculatedConfig = [];
        try {
            $calculatedConfig = $processor->processConfiguration(new Configuration(), [$sourceConfig]);
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
}

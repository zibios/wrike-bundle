<?php

/*
 * This file is part of the zibios/wrike-bundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\Tests\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Zibios\Bundle\WrikeBundle\Tests\TestCase;

/**
 * DependencyInjectionTestCase.
 */
abstract class DependencyInjectionTestCase extends TestCase
{
    /**
     * @return array
     */
    public function configurationProvider()
    {
        return [
            // [sourceConfig, expectedConfig, expectedExceptionClass]
            // default
            [
                [],
                [],
                false,
            ],
            // api_url
            [
                ['api_url' => null],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['api_url' => ''],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['api_url' => []],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['api_url' => 'validToken'],
                ['api_url' => 'validToken'],
                false,
            ],
            // permanent_token -> tokens
            [
                ['permanent_tokens' => ['tokens' => null]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => '']],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => []]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => ['test']]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => ['test' => '']]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => [null => 'validToken']]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => ['' => 'validToken']]],
                [],
                InvalidConfigurationException::class,
            ],
            [
                ['permanent_tokens' => ['tokens' => ['validName' => 'validToken']]],
                ['permanent_tokens' => ['tokens' => ['validName' => 'validToken']]],
                false,
            ],
            [
                ['permanent_tokens' => ['default_token' => 'validName', 'tokens' => ['validName' => 'validToken']]],
                ['permanent_tokens' => ['default_token' => 'validName', 'tokens' => ['validName' => 'validToken']]],
                false,
            ],
            [
                ['permanent_tokens' => ['default_token' => 'default', 'tokens' => ['validName' => 'validToken']]],
                [],
                InvalidConfigurationException::class,
            ],
        ];
    }
}

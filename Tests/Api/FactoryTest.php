<?php
/**
 * This file is part of the WrikeBundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\Tests\Api;

use Zibios\Bundle\WrikeBundle\Api\Factory;
use Zibios\Bundle\WrikeBundle\Tests\TestCase;
use Zibios\WrikePhpLibrary\Api;

/**
 * FactoryTest
 */
class FactoryTest extends TestCase
{
    public function test_create()
    {
        $api = Factory::create();
        self::assertInstanceOf(Api::class, $api);
        self::assertEquals('', $api->getBearerToken());
    }

    public function test_createForPermanentToken()
    {
        $token = 'TestToken';
        $api = Factory::createForPermanentToken($token);
        self::assertInstanceOf(Api::class, $api);
        self::assertEquals($token, $api->getBearerToken());
    }
}

<?php
/**
 * This file is part of the WrikeBundle package.
 *
 * (c) Zbigniew Ślązak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zibios\Bundle\WrikeBundle\Api;

use Zibios\WrikePhpSdk\ApiFactory;

/**
 * Factory.
 */
class Factory
{
    /**
     * @return \Zibios\WrikePhpLibrary\Api
     * @throws \InvalidArgumentException
     */
    public static function create()
    {
        return ApiFactory::create();
    }

    /**
     * @param string $token
     *
     * @return \Zibios\WrikePhpLibrary\Api
     * @throws \InvalidArgumentException
     */
    public static function createForPermanentToken($token)
    {
        return ApiFactory::createForBearerToken($token);
    }
}

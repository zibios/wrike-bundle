<?php

/*
 * This file is part of the zibios/wrike-bundle package.
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
     * Create Api instance.
     *
     * @throws \InvalidArgumentException
     *
     * @return \Zibios\WrikePhpLibrary\Api
     */
    public static function create()
    {
        return ApiFactory::create();
    }

    /**
     * Create Api instance with access token.
     *
     * @param string $token
     *
     * @throws \InvalidArgumentException
     *
     * @return \Zibios\WrikePhpLibrary\Api
     */
    public static function createForPermanentToken($token)
    {
        return ApiFactory::createForBearerToken($token);
    }
}

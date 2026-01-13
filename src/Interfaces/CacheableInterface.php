<?php /** @noinspection PhpUnused */

namespace Bayfront\BonesService\Cache\Interfaces;

interface CacheableInterface
{

    /**
     * Get prefix to be applied to all cache item keys.
     *
     * @return string
     */
    public function getCachePrefix(): string;

    /**
     * Get cache key with prefix applied.
     *
     * @param string $key
     * @return string
     */
    public function getCacheKey(string $key): string;

}
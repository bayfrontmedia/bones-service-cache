<?php /** @noinspection PhpUnused */

namespace Bayfront\BonesService\Cache;

use Bayfront\Bones\Abstracts\Service;
use Bayfront\Bones\Application\Services\Events\EventService;
use Bayfront\Bones\Application\Services\Filters\FilterService;
use Bayfront\BonesService\Cache\Exceptions\CacheDoesNotExistException;
use Bayfront\BonesService\Cache\Exceptions\CacheServiceException;
use Bayfront\BonesService\Cache\Exceptions\InvalidCacheKeyException;
use Bayfront\Cache\Interfaces\CacheItemPoolInterface;
use DateInterval;
use Psr\Cache\InvalidArgumentException;

class CacheService extends Service
{

    public EventService $events;
    public FilterService $filters;
    public CacheItemPoolInterface $cacheItemPool;

    /**
     * @param EventService $events
     * @param FilterService $filters
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function __construct(EventService $events, FilterService $filters, CacheItemPoolInterface $cacheItemPool)
    {

        parent::__construct($events);

        $this->events = $events;
        $this->filters = $filters;
        $this->cacheItemPool = $cacheItemPool;

        $events->doEvent('cache.start', $this);

    }

    /**
     * Does cache contain item?
     *
     * @param string $key
     * @return bool
     * @throws InvalidCacheKeyException
     */
    public function hasItem(string $key): bool
    {
        try {
            return $this->cacheItemPool->hasItem($key);
        } catch (InvalidArgumentException) {
            throw new InvalidCacheKeyException('Unable to read cache item: Invalid key (' . $key . ')');
        }
    }

    /**
     * Get the value of the item from the cache.
     *
     * If existing, the cache.hit event is emitted.
     *
     * @param string $key
     * @return mixed
     * @throws CacheDoesNotExistException
     * @throws InvalidCacheKeyException
     */
    public function getItem(string $key): mixed
    {

        try {
            $item = $this->cacheItemPool->getItem($key);
        } catch (InvalidArgumentException) {
            throw new InvalidCacheKeyException('Unable to get cache item: Invalid key: (' . $key . ')');
        }

        if (!$item->isHit()) {
            throw new CacheDoesNotExistException('Unable to get cache item: Item does not exist');
        }

        $this->events->doEvent('cache.item.hit', $item);

        return $item->get();

    }

    /**
     * Save item to cache.
     *
     * The CacheItemInterface is filtered by the cache.item filter before being saved.
     * On completion, the cache.saved event is emitted.
     *
     * @param string $key
     * @param mixed $value
     * @param DateInterval|int|null $ttl (Expiration time for cache item. Passing null will remove any expiration. Integer as time in seconds.)
     * @return bool
     * @throws InvalidCacheKeyException
     */
    public function saveItem(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {

        try {
            $item = $this->cacheItemPool->getItem($key);
        } catch (InvalidArgumentException) {
            throw new InvalidCacheKeyException('Unable to save cache item: Invalid key: (' . $key . ')');
        }

        $item->set($value)->expiresAfter($ttl);

        $item = $this->filters->doFilter('cache.item.save', $item);

        $saved = $this->cacheItemPool->save($item);

        if ($saved === true) {
            $this->events->doEvent('cache.item.saved', $item);
        }

        return $saved;

    }

    /**
     * Delete item from cache.
     *
     * On success, the cache.deleted event is emitted.
     *
     * @param string $key
     * @return bool
     * @throws InvalidCacheKeyException
     */
    public function deleteItem(string $key): bool
    {

        try {
            $deleted = $this->cacheItemPool->deleteItem($key);
        } catch (InvalidArgumentException) {
            throw new InvalidCacheKeyException('Unable to delete cache item: Invalid key: (' . $key . ')');
        }

        if ($deleted === true) {
            $this->events->doEvent('cache.item.deleted', $key);
        }

        return $deleted;

    }

    /**
     * Delete all items whose key begins with prefix.
     *
     * @param string $prefix
     * @param int $batch_size
     * @return bool
     * @throws InvalidCacheKeyException
     */
    public function deleteItemsWithPrefix(string $prefix, int $batch_size = 500): bool
    {

        try {
            return $this->cacheItemPool->deleteItemsWithPrefix($prefix, $batch_size);
        } catch (InvalidArgumentException) {
            throw new InvalidCacheKeyException('Unable to delete cache items with prefix: Invalid prefix: (' . $prefix . ')');
        }

    }

}
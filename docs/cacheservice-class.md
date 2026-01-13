# Cache service: CacheService class

The `Bayfront\BonesService\Cache\CacheService` class contains the following Bones services:

- [EventService](https://github.com/bayfrontmedia/bones/blob/master/docs/services/events.md) as `$this->events`
- [FilterService](https://github.com/bayfrontmedia/bones/blob/master/docs/services/filters.md) as `$this->filters`
- [CacheItemPoolInterface](https://github.com/bayfrontmedia/php-cache/blob/master/docs/interfaces/cacheitempoolinterface.md) as `$this->cacheItemPool`

Methods include:

## hasItem

Does cache contain item?

**Parameters:**

- `$key` (string)

**Returns:**

- (bool)

**Throws:**

- `Bayfront\BonesService\Cache\Exceptions\InvalidCacheKeyException`

## getItem

Get the value of the item from the cache.

If existing, the `cache.hit` [event](events.md) is emitted.

**Parameters:**

- `$key` (string)

**Returns:**

- (mixed)

**Throws:**

- `Bayfront\BonesService\Cache\Exceptions\CacheDoesNotExistException`
- `Bayfront\BonesService\Cache\Exceptions\InvalidCacheKeyException`

## saveItem

Save item to cache.

The [CacheItemInterface](https://github.com/bayfrontmedia/php-cache/blob/master/docs/interfaces/cacheiteminterface.md) 
is filtered by the `cache.item` [filter](filters.md) before being saved.
On completion, the `cache.saved` [event](events.md) is emitted.

**Parameters:**

- `$key` (string)
- `$value` (mixed)
- `$ttl = null` (`DateInterval`|int|null): Expiration time for cache item. Passing `null` will remove any expiration. Integer as time in seconds.

**Returns:**

- (bool)

**Throws:**

- `Bayfront\BonesService\Cache\Exceptions\InvalidCacheKeyException`

## deleteItem

Delete item from cache.

On success, the `cache.deleted` [event](events.md) is emitted.

**Parameters:**

- `$key` (string)

**Returns:**

- (bool)
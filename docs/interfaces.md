# Cache service: Interfaces

The following interfaces are included with this service:

## CacheableInterface

The `Bayfront\BonesService\Cache\Interfaces\CacheableInterface` can be helpful to use when needing to
add fine-grained prefixes on the cache item keys. This would typically be done from inside a model.

Methods include:

### getCachePrefix

Get prefix to be applied to all cache item keys.

**Parameters:**

- None

**Returns:**

- (string)

<hr />

### getCacheKey

Get cache key with prefix applied.

**Parameters:**

- `$key` (string)

**Returns:**

- (string)
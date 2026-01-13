# Cache service: Events

The following [events](https://github.com/bayfrontmedia/bones/blob/master/docs/services/events.md) are added by this service:

- `cache.start`: Executes in the [CacheService](cacheservice-class.md) constructor as the first event available to this service.
  The `CacheService` instance is passed as a parameter.
- `cache.item.hit`: Executes when an item has been retrieved from the cache. A [CacheItemInterface](https://github.com/bayfrontmedia/php-cache/blob/master/docs/interfaces/cacheiteminterface.md) 
representing the item is passed as a parameter.
- `cache.item.saved`: Executes when an item has been saved to the cache. A [CacheItemInterface](https://github.com/bayfrontmedia/php-cache/blob/master/docs/interfaces/cacheiteminterface.md)
  representing the item is passed as a parameter.
- `cache.item.deleted`: Executes when an item has been deleted from the cache. A [CacheItemInterface](https://github.com/bayfrontmedia/php-cache/blob/master/docs/interfaces/cacheiteminterface.md)
  representing the item is passed as a parameter.
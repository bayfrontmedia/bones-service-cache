# Cache service: Initial setup

- [Add to container](#add-to-container)

## Add to container

This service makes use of the [PHP-Cache](https://github.com/bayfrontmedia/php-cache/) library, so a `Bayfront\Cache\Interfaces\CacheItemPoolInterface`
must be created.

A `CacheService` instance needs to be added to the Bones [service container](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/container.md).
This is typically done in the `resources/bootstrap.php` file.
You may also wish to create an alias.

For more information, see [Bones bootstrap documentation](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/bootstrap.md).

```php
$cacheService = $container->make('Bayfront\BonesService\Cache\CacheService', [
    'cacheItemPool' => $cachePool // $cachePool as a CacheItemPoolInterface instance
]);

$container->set('Bayfront\BonesService\Cache\CacheService', $cacheService);
$container->setAlias('cacheService', 'Bayfront\BonesService\Cache\CacheService');
```
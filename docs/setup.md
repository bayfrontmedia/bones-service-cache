# Cache service: Initial setup

- [Dependencies](#dependencies)
- [Add to container](#add-to-container)

## Dependencies

This service also requires the following library to exist in the container:

- [PHP-Cache](https://github.com/bayfrontmedia/php-cache/)

## Add to container

A `CacheItemPoolInterface` instance from the PHP-Cache library needs to be added to the Bones [service container](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/container.md).
This is typically done in the `resources/bootstrap.php` file.
You may also wish to create an alias.

For more information, see [Bones bootstrap documentation](https://github.com/bayfrontmedia/bones/blob/master/docs/usage/bootstrap.md).

```php
$cacheService = $container->make('Bayfront\BonesService\Cache\CacheService');
$container->set('Bayfront\BonesService\Cache\CacheService', $cacheService);
$container->setAlias('cacheService', 'Bayfront\BonesService\Cache\CacheService');
```
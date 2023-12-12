# UPGRADING

## [3.0.0] - 2024-01-01

_Because of fundamental changes there are some important steps to work with sites continuosly._

### Force update configuration

Configuration is the smallest part of this business. Just make backup copy of your current `config\site.php`, then run:

```bash
php artisan vendor:publish --tag="neon-site-config" --force
```

After that, you can re-apply your settings in `config\neon-site.php` file.

### Site Middleware

Site middleware removed, so does not exists in the package furthermore. To remove, edit `app\Http\Kernel.php`:

```php
/**
 * The application's route middleware groups.
 *
 * @var array<string, array<int, class-string|string>>
 */
protected $middlewareGroups = [
  'web' => [
    // Other middlewares...

    /**
     * THIS LINE SHOULD BE REMOVED!!!
     */
    \Neon\Site\Http\Middleware\SiteMiddleware::class,
  ]
];
```

### Database

This is the most tricky part.
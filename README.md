# NEON &mdash; Site
Handles sites to be able to run on it.

## Requirements
* `"neon/model-uuid": "^1.0"`

## Install
Easily install the composer package:
```bash
composer require neon/site
```
Then there are two ways to use the site: You can store your settings both in config file or in database. It depends on your wishes, you can install package on both ways.

### Install config files

### Install database migrations

Then you should install database migrations by:
```bash
php artisan vendor:publish --provider=\"Neon\\Site\\NeonSiteServiceProvider\"
```

## Usage

Site Middleware as of 2.0 does not add automatically to the array of middleware, so, if you want to use it, you should set up that for the routing:

```php
use Neon\Site\Facades\Site;


Site::patterns();
```

This command will define the Site rules for Laravel's router. After this definition you can use it for different cases:

```php
use Neon\Site\Facades\Site;
use Neon\Site\Http\Middleware\SiteMiddleware;

Route::group([
    'domain'      => Site::domain('domain_slug'),
    'middleware'  => SiteMiddleware::class
  ], function () {

  Route::group([
    'middleware'  => [SiteMiddleware::class]
  ], function () {

    Route::get('/', function() {
      echo 'Hello '.app('site')->current()->locale.' /// DOMAIN';
    });
  });
});
```

If you want to separate routing by locale you can use it like this:

```php
    'prefix'      => 'en',
```

You can also use site as prefixes:

```php
use Neon\Site\Facades\Site;
use Neon\Site\Http\Middleware\SiteMiddleware;

Route::group([
    'prefix'      => Site::prefix('prefix_slug'),
    'middleware'  => SiteMiddleware::class
  ], function () {
  ...
});
```

### SEO functions

#### Use favicon

Favicon could be set on admin UI. After that, yo can easily put it into the header right after the `<title>` tag:

```html
<head>
  <title>...</title>
  <x-neon-favicon/>
  ...
</head>
```
### Site dependent models

If you want something, like a Menu, what is rlated to the Site, then you just have to use the dependency trait.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Neon\Attributable\Models\Traits\Attributable; //- You cab check this too...
use Neon\Models\Traits\Uuid;
use Neon\Site\Models\Traits\SiteDependencies;

class AwesomeModel extends Model
{
    use Attributable;
    use Uuid;
    use SiteDependencies;

    ...

}
```
<!-- ## How It Works?

It's so easy basically. The "variables", a.k.a. attributes stored in database in the `attributes` table. -->

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
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

### Install database migrations

Then you should install database migrations by:
```bash
php artisan vendor:publish --tag=neon-site-migrations
```

## Usage

Usage is so simply because of the Site handler stuff, what recognizes the domain or the prefix to determine the current Site object.

### Site dependent models

If you want something, like a Menu, what is rlated to the Site, then you just have to use the dependency trait.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Neon\Models\Traits\Uuid;
use Neon\Site\Models\Traits\SiteDependencies;

class AwesomeModel extends Model
{
    use Uuid;
    use SiteDependencies;

    ...

}
```
The trait will automatically add the scope to the given model, so, when you querying for the given model records, it will always select those ones what are depends on the current site.

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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
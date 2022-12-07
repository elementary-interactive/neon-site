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
Just use the Trait like othes traits. Don't forget to use the `neon/model-uuid` trait too:
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Neon\Attributables\Models\Traits\Attributables;
use Neon\Models\Traits\Uuid;

class AwesomeModel extends Model
{
    use Attributables;
    use Uuid;

    ...

}
```
<!-- ## How It Works?

It's so easy basically. The "variables", a.k.a. attributes stored in database in the `attributes` table. -->

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
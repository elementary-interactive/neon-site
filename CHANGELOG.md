# Changelog

## [3.0.0] - 2024-01-01

_Because of fundamental changes, if you are upgrading: Please see [`UPGRADING.md`](UPGRADING.md)._

Theoretically, the new Site methodology does not control or limit anything related to the routing, just helps to recognize domain, subdomain, or group.

### Removed

- **Breaking:** Multiple dependencies removed, Site dependent connection means a simple [BelongsTo](https://laravel.com/docs/10.x/eloquent-relationships#one-to-many-inverse) connection.
- **Breaking:** Standalone vs Database configuration removed.
- **Breaking:** Site ID creator command removed.
- Site Middleware not necessary, removed.

### Changes

- The Site singleton has a new method: `findByPrefix()` what checks the site's prefix based on the current route.

### Additions

- SiteInterface with two methods: `getDomainPattern()` and `getPrefixPattern()` what must be implementend in the model what is representing a site. (By default it is `Neon\Site\Models\Site` class.)
- Using Spatie's Laravel Package Tools.
- PEST test environment added.

## [2.0.5] ... [1.0.0] 





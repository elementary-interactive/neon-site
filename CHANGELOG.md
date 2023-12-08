# Changelog

## [3.0.0] - 2024-01-01

_Because of fundamental changes, if you are upgrading: Please see [`UPGRADING.md`](UPGRADING.md)._

Theoretically the new Site methodology does not controll or limit anything related the routing, just helps to recognize domain, subdomain or group.

### Removed

- **Breaking:** Multiple dependency removed, Site dependent connection means a simple [BelongsTo](https://laravel.com/docs/10.x/eloquent-relationships#one-to-many-inverse)connection.
- **Breaking:** Standalone vs Database configuration removed.
- **Breaking:** Site ID creator command removed.
- PEST test environment added.


## [1.0.0] - 

_First release_

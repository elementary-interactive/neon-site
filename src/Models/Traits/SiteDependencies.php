<?php

namespace Neon\Site\Models\Traits;

use Neon\Site\Models\Site;
use Neon\Site\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** 
 
 * 
 * @author: Balázs Ercsey <balazs.ercsey@elementary-interactive.com>
 */
trait SiteDependencies
{
  /** Boot the Site dependency trait for a model.
   * 
   * @return void
   */
  public static function bootSiteDependencies()
  {
    static::addGlobalScope(new SiteScope);
  }

  /** Get connected sites.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function site()
  {
    return $this->belongsToMany(config('site.model') ?? Site::class, 'site_dependencies', 'dependence_id', 'site_id')
      ->wherePivot('dependence_type', self::class)
      ->using(\Neon\Site\Models\SiteDependencies::class);
  }

  /** Get connections to sites.
   * 
   * Thie method not going to get sites, just the dependencies.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function dependencies()
  {
      return $this->belongsTo(\Neon\Site\Models\SiteDependencies::class, 'id', 'dependence_id')
        ->withDefault([
          'dependence_type' => self::class
        ]);
  }
}

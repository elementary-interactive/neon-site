<?php

namespace Neon\Site\Models\Traits;

use Neon\Site\Models\Site;
use Neon\Site\Models\SiteDependencies as SiteDependeciesModel;
use Neon\Site\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/** 
 
 * 
 * @author: Balázs Ercsey <balazs.ercsey@elementary-interactive.com>
 */
trait SiteDependencies
{
  protected function initializeSiteDependencies()
  {
    static::addGlobalScope(new SiteScope);
  }

  /** Get connected sites.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
   */
  public function site()
  {
    return $this->belongsToMany(config('site.class') ?? Site::class, 'site_dependencies', 'dependence_id', 'site_id')
      ->wherePivot('dependence_type', self::class)
      ->using(SiteDependenciesModel::class);
  }

  /** Get connections to sites.
   * 
   * Thie method not going to get sites, just the dependencies.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function dependencies()
  {
      return $this->belongsTo(SiteDependeciesModel::class, 'id', 'dependence_id')
        ->withDefault([
          'dependence_type' => self::class
        ]);
  }
}

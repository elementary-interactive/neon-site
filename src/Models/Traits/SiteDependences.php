<?php

namespace Neon\Site\Models\Traits;

use Neon\Site\Models\Site;
use Neon\Site\Models\SiteDependences as SiteDependecesModel;
use Neon\Site\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** 
 
 * 
 * @author: Balázs Ercsey <balazs.ercsey@elementary-interactive.com>
 */
trait SiteDependences
{
  protected function initializeSiteDependences()
  {
    static::addGlobalScope(new SiteScope);
  }

  /** Get connected sites.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function site()
  {
    return $this->belongsToMany(config('site.class') ?? Site::class, 'site_dependences', 'dependence_id', 'site_id')
      ->wherePivot('dependence_type', self::class)
      ->using(SiteDependencesModel::class);
  }
}

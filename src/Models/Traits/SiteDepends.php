<?php

namespace Neon\Sites\Models\Traits;

use Neon\Sites\Models\Site;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** 
 
 * 
 * @author: Balázs Ercsey <balazs.ercsey@elementary-interactive.com>
 */
trait SiteDepends
{
  protected function initializeSiteDepends()
  {
    $site_class = config('sites.class');
    
    $site_class::hasMany(self::class);
  }

  /** Get connected sites.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function site()
  {
    return $this->belongsTo(Site::class);
  }

  /**
   * Scope a query to only include site related objects.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @param mixed $site
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeOfType($query, $site)
  {
    return $query->with(['site' => function ($q) use ($site) {
      $q->where('id', $site->id);
    }])->get();
  }
}

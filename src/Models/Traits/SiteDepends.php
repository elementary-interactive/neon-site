<?php

namespace Neon\Site\Models\Traits;

use Neon\Site\Models\Site;
use Neon\Site\Models\SiteDepends as ModelsSiteDepends;
use Neon\Site\Models\Scopes\SiteScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** 
 
 * 
 * @author: Balázs Ercsey <balazs.ercsey@elementary-interactive.com>
 */
trait SiteDepends
{
  protected function initializeSiteDepends()
  {
    static::addGlobalScope(new SiteScope);
  }

  /** Get connected sites.
   * 
   * @return Illuminate\Database\Eloquent\Relations\BelongsTo
   */
  public function site()
  {
    return $this->belongsToMany(config('site.class') ?? Site::class)->using(ModelsSiteDepends::class);
  }
}

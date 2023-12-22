<?php

namespace Neon\Site\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SiteScope implements Scope
{
  /**
   * Apply the scope to a given Eloquent query builder.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $builder
   * @param  \Illuminate\Database\Eloquent\Model  $model
   * @return void
   */
  public function apply(Builder $builder, Model $model)
  {
    /** Scope querying over not site but dependencies because if
     * developer uses file drive for sites then the site-based
     * querying will not work, as the site's object is not exists
     * in the datbase only in memory.
     */
    return $builder->whereHas('site', function ($query) {
      $query->where('id', app('site')->current()?->id);
    });
  }
}

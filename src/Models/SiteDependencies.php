<?php
 
namespace Neon\Site\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class SiteDependencies extends Pivot
{
  protected $table = 'site_dependencies';

  protected static function boot()
  {
      /** We MUST call the parent boot method  in this case the:
       *      \Illuminate\Database\Eloquent\Model
       */
      parent::boot();

      static::saving(function($model)
      {
        if (is_object($model->pivotParent))
        {
          $model->attributes['dependence_type'] = get_class($model->pivotParent);
        }
      });
  }
}
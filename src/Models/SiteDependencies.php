<?php
 
namespace Neon\Site\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
 
class SiteDependencies extends Pivot
{
  protected $table = 'site_dependencies';
}
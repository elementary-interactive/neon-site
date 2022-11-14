<?php

namespace Neon\Site;

use \Illuminate\Support\Str;
use \Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Storage;
use \Illuminate\Contracts\Http\Kernel;
use \Neon\Site\Http\Middleware\SiteMiddleware;

class NeonSiteServiceProvider extends ServiceProvider
{

  /** Bootstrap any application services.
   *
   * @param \Illuminate\Contracts\Http\Kernel  $kernel
   *
   * @return void
   */
  public function boot(Kernel $kernel): void
  {
  //   if ($this->app->runningInConsole()) {
      
  //     /** Export migrations.
  //      */
  //     // $this->publishes([
  //     //   __DIR__ . '/../database/migrations/create_attributes_table.php.stub'        => database_path('migrations/' . date('Y_m_d_', time()) . '000001_create_attributes_table.php'),
  //     //   __DIR__ . '/../database/migrations/create_attribute_values_table.php.stub'  => database_path('migrations/' . date('Y_m_d_', time()) . '000002_create_attribute_values_table.php'),
  //     // ], 'neon-migrations');
  //   }
  // }

    $kernel->pushMiddleware(SiteMiddleware::class);
    
    if ($this->app->runningInConsole())
    {
      // file_put_contents(__DIR__.'/../config/config.php', Str::of(file_get_contents(__DIR__.'/../config/config.php'))->replace('##uuid##', Str::uuid()));
      // Storage::put(__DIR__.'/../config/config.php', Str::of(Storage::get(__DIR__.'/../config/config.php'))->replace('##uuid##', Str::uuid()));

      $this->publishes([
        __DIR__.'/../config/config.php'   => config_path('site.php'),
      ], 'neon-site-config');

    }
  }

  public function register()
  {
    $this->app->bind('site', function($app) {
      return new Site();
    });
  //   $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'neon-config');
  }
}

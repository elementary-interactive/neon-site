<?php

namespace Neon\Site;

use Illuminate\Foundation\Console\AboutCommand;
use Neon\Site\Console\SiteClearCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Neon\Site\View\Components\Favicon;
use Spatie\LaravelPackageTools\Commands\InstallCommand;


class NeonSiteServiceProvider extends PackageServiceProvider
{
  const VERSION = '3.0.0-alpha-4';

  public function configurePackage(Package $package): void
  {
    AboutCommand::add('Neon', 'Site', self::VERSION);

    $package
      ->name('neon-site')
      ->hasConfigFile()
      ->hasViews()
      ->hasViewComponent('neon-site', Favicon::class)
      ->hasMigration('create_sites_table')
      ->hasMigration('create_site_dependencies_table')
      ->hasCommands([SiteClearCommand::class]);
  }


  public function packageRegistered()
  {
    $this->app->singleton('site', function ($app) {
      return new Site();
    });
  }
}

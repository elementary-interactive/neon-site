<?php

namespace Neon\Site;

use Neon\Site\Console\SiteClearCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Neon\Site\View\Components\Favicon;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class NeonSiteServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('neon-site')
            // ->hasConfigFile()
            ->hasViews()
            ->hasViewComponent('neon', Favicon::class)
            // ->sharesDataWithAllViews('downloads', 3)
            // ->hasTranslations()
            // ->hasAssets()
            // ->publishesServiceProvider('site')
            // ->hasRoute('web')
            ->hasMigration('create_sites_table')
            ->hasCommand(SiteClearCommand::class);
            // ->hasInstallCommand(function(InstallCommand $command) {
            //     $command
            //         ->publishConfigFile()
            //         ->publishAssets()
            //         ->publishMigrations()
            //         ->copyAndRegisterServiceProviderInApp()
            //         ->askToStarRepoOnGitHub();
            // });
    }

    
  public function packageRegistered()
  {
    $this->app->singleton('site', function($app) {
      return new Site();
    });
  }
}
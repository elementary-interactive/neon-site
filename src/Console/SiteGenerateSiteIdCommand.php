// src/Console/SiteClearCommand.php
<?php

namespace Neon\Site\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SiteGenerateSiteIdCommand extends Command
{
  /**
   * @var string The command.
   */
  protected $signature = 'site:generate';

  protected $description = 'Add Neon\' site id to env.';

  public final function handle()
  {
    $path = app()->environmentFilePath();

    $escaped = preg_quote('='.env('SITE_ID'), '/');

    file_put_contents($path, preg_replace(
        "/^SITE_ID{$escaped}/m",
       "SITE_ID={\Str::uuid()}",
       file_get_contents($path)
    ));
  }
}

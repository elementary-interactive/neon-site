<?php

namespace Neon\Site\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SiteClearCommand extends Command
{
  /**
   * @var string The command.
   */
  protected $signature = 'site:clear';

  protected $description = 'Clear Neon\'s site cache.';

  public final function handle()
  {
    if (config('neon-site.cache'))
    {
      Cache::forget('neon-site');
      $this->info('Cache flushed.');
    } else {
      $this->warn('Cache is turned off by the config.');
    }
  }
}

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

  protected $description = 'Clear Neon\' site cache.';

  public final function handle()
  {
    Cache::forget('neon-site');
  }
}

<?php

namespace Neon\Site\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SiteGenerateSiteIdCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'site:generate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Add SITE_ID to environment. It\'s needed for Neon to be able to run.';

  private $path;

  private $content;

  public final function handle()
  {
    /**
     * @var string The environment file path.
     */
    $this->path = app()->environmentFilePath();

    /**
     * @var string Content of the file.
     */
    $this->content = file_get_contents($this->path);

    $matches = [];
    preg_match('/SITE_ID\=/', $this->content, $matches);

    if (!count($matches)) {

      /**
       * SITE_ID not set yet, just add it, and go...
       */
      file_put_contents($this->path, $this->content.PHP_EOL."SITE_ID=".\Str::uuid(),PHP_EOL."SITE_DRIVER=file");
    } else {
      file_put_contents($this->path, preg_replace(
        "/^SITE_ID".preg_quote(env('SITE_ID').'=', '/')."/m",
        "SITE_ID=".\Str::uuid(),
        $this->content
      ));

    }
    $this->info('Site identifier set successfully.');
    
    return 0;
  }
}

<?phpS

namespace Neon\Site;

use Neon\Site\Models\Site as SiteModel;

class Site
{
  private $driver = 'file';

  private $sites = null;

  public function __construct()
  {
    $this->driver = config('site.driver');
    $this->sites = ($this->engine === 'file') ? collect(config('site.hosts')) : SiteModel::all();
  }

  public function find($host)
  {
    $site = $this->sites->each(function ($item, $key) use ($host) {
      if ($key === 'domains' && in_array($host, $item)) {
        return true;
      }
    })->first();

    return $site;
  }

  public function findOrDefault($host)
  {
    $site = $this->find($host);

    return $site;
  }
}

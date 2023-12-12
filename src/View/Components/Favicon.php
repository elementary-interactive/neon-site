<?php

namespace Neon\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Favicon extends Component
{
  /**
   * Create the component instance.
   *
   * @return void
   */
  public function __construct()
  {
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|\Closure|string
   */
  public function render()
  {
    return view('neon-site::components.favicon', [
      'icon' => app('site')->current()?->favicon,
    ]);
  }
}

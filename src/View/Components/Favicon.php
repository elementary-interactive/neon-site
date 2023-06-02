<?php

namespace Neon\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Favicon extends Component
{
  /**
   * Create the component instance.
   *
   * @param  \Neon\Services\MenuService $service
   * @param  string  $id
   * 
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\View\View|\Closure|string
   */
  public function render()
  {
    return view('neon::favicon', [
      'icon' => app('site')->current()->favicon,
    ]);
  }
}

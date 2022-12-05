<?php

return [

  /** 
   * The driver of the sites' config. This controls the default site "driver"
   * will be used on request. By default it's "file" what means, we will use
   * this certain file to indentify sites where the project could be run.
   * 
   * Supported: "file", "database"
   */
  'driver' => env('SITE_DRIVER', 'file'),

  /**
   * The class what will represent a site.
   */
  'class' => \Neon\Site\Models\Site::class,

  /**
   * List of the sites.
   * - The site's ID will be used as primary key value for site related contents.
   * - Possible arguments:
   *    - domains: List of strings. On these sites we'll use the givem config.
   *    - default: Boolean. If no sites could be identified by domain, then we'll select by this.
   */
  'hosts' => [
    env('SITE_ID') => [
      'domains' => ['example.com'],
      'default' => true
    ],
    'dev' => [
      'domains' => []
    ]
  ]
];
<?php

return [

  /** IMPORTANT!!!
   * 
   * Sites, to make you project fast and easy to run is hardly caching the sites' configuration even
   * if its given in the config file or in the database. Take care of change this file, and always
   * run the next command:
   * ```
   *   php artisan site:clear
   * ```
   * This will prune all sites caches.
   */
  'cache' => env('NEON_CACHE_SITE', true),

  /**
   * The class what will represent a site.
   */
  'model' => \Neon\Site\Models\Site::class,
];
<?php

return [
  'driver' => env('SITE_DRIVER', 'file'),

  'class' => \Neon\Site\Models\Site::class,

  'hosts' => [
    env('SITE_ID') => [
      'domains'    => ['example.com']
    ],
    'dev' => [
      'domains' => ['localhost']
    ]
  ]
];
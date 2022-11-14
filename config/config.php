<?php

return [
  'driver'    => env('SITE_DRIVER', 'file'),

  'hosts' => [
    env('SITE_ID') => [
      'domains'    => ['example.com']
    ],
    'dev' => [
      'domains' => ['localhost']
    ]
  ]
];
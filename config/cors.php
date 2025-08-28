<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Sesuaikan dengan endpoint API Anda
    'allowed_methods' => ['*'], // Izinkan semua metode (GET, POST, PUT, DELETE, dsb)
    'allowed_origins' => ['*'], // Izinkan semua domain
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'], // Izinkan semua headers
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];


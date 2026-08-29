<?php
// ════════════════════════════════════════════════
// config/cors.php  — Allow frontend to call the API
// ════════════════════════════════════════════════
return [

    /*
     |------------------------------------------------------------------
     | Cross-Origin Resource Sharing (CORS)
     |------------------------------------------------------------------
     | Change 'allowed_origins' to your frontend URL in production.
     | For XAMPP local dev, use http://localhost or http://127.0.0.1
     */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost',
        'http://127.0.0.1',
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://localhost:5500',   // VS Code Live Server
        'http://127.0.0.1:5500',
        // Add your production domain here:
        // 'https://yourdomain.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];


// ════════════════════════════════════════════════
// config/sanctum.php  (key parts only)
// ════════════════════════════════════════════════
// In your .env file, make sure you have:
//
//   SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1,localhost:5500
//   SESSION_DOMAIN=localhost
//
// For pure token-based auth (SPA on a separate origin),
// Sanctum works with Bearer tokens — no additional config needed.
// The AuthController already returns plainTextToken.

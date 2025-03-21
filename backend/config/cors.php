<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],  // Nếu cần, bạn có thể chỉ định các phương thức cụ thể như GET, POST, PUT,...

    'allowed_origins' => ['http://localhost:3000'],  // Đặt origin chính xác của ứng dụng frontend

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],  // Hoặc chỉ định các headers cần thiết như Content-Type, Authorization, ...

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];

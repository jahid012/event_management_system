<?php
// Get the route from the URL
$route = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Define available routes
$routes = [
  'register' => 'register.php',
  'login' => 'login.php',
  'api' => 'api.php',
  'dashboard' => 'layout.php',
  'events' => 'layout.php',
  'view_event' => 'layout.php',
  'manage_event' => 'layout.php',
  'audience_report' => 'layout.php',
];

// Security: Prevent direct access to sensitive files
if (strpos($route, '..') !== false) {
  http_response_code(403);
  die('Access denied!');
}

// Check if the requested route exists
if (array_key_exists($route, $routes)) {
  include $routes[$route];
} else {
  http_response_code(404);
  die('Page Not Found');
}

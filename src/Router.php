<?php
  declare(strict_types = 1);

  class Router {
    private $routes = [];

    // Add a GET route with dynamic paths
    public function get($path, $action) {
        $this->routes['GET'][$path] = $action;
    }

    // Add a POST route
    public function post($path, $action) {
        $this->routes['POST'][$path] = $action;
    }

    // Dispatch the request
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['REQUEST_URI'];
        
        // Remove query string if present
        $path = strtok($path, '?');

        // Match routes
        foreach ($this->routes[$method] as $route => $action) {
            // Handle dynamic paths (e.g., /user/{id})
            $pattern = $this->convertToRegex($route);
            if (preg_match($pattern, $path, $matches)) {
                // Capture the dynamic segments
                array_shift($matches); // Remove full match
                call_user_func_array($action, $matches);
                return;
            }
        }

        // If no route was matched
        http_response_code(404);
        echo "404 Not Found";
    }

    // Convert a path to a regular expression
    private function convertToRegex($route) {
        $route = preg_replace('/\//', '\\/', $route); // Escape slashes
        $route = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '(?P<$1>[^/]+)', $route); // Capture dynamic parameters
        $route = '^' . $route . '$'; // Match exact path
        return '/' . $route . '/';
    }
  }
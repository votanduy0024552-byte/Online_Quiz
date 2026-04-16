<?php
/**
 * API Router
 * 
 * Handles routing for all API endpoints
 */

class Router {
    private $routes = [];
    private $method;
    private $uri;
    
    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = str_replace(APP_URL, '', $this->uri);
        $this->uri = trim($this->uri, '/');
    }
    
    /**
     * Register GET route
     */
    public function get($pattern, $callback) {
        $this->addRoute('GET', $pattern, $callback);
    }
    
    /**
     * Register POST route
     */
    public function post($pattern, $callback) {
        $this->addRoute('POST', $pattern, $callback);
    }
    
    /**
     * Register PUT route
     */
    public function put($pattern, $callback) {
        $this->addRoute('PUT', $pattern, $callback);
    }
    
    /**
     * Register DELETE route
     */
    public function delete($pattern, $callback) {
        $this->addRoute('DELETE', $pattern, $callback);
    }
    
    /**
     * Add route
     */
    private function addRoute($method, $pattern, $callback) {
        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'callback' => $callback
        ];
    }
    
    /**
     * Dispatch request
     */
    public function dispatch() {
        foreach ($this->routes as $route) {
            if ($this->method !== $route['method']) continue;
            
            if ($this->matchRoute($route['pattern'], $params)) {
                return call_user_func($route['callback'], $params);
            }
        }
        
        // Route not found
        Response::json(Response::error('Endpoint not found', HTTP_NOT_FOUND), HTTP_NOT_FOUND);
    }
    
    /**
     * Match route pattern
     */
    private function matchRoute($pattern, &$params) {
        $pattern = str_replace(':id', '(\d+)', $pattern);
        $pattern = '^' . $pattern . '\$';
        
        if (preg_match('/' . $pattern . '/', $this->uri, $matches)) {
            $params = array_slice($matches, 1);
            return true;
        }
        return false;
    }
}
?>

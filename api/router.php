<?php
/**
 * API Router
 * 
 * Handles routing for all API endpoints
 */

class Router {
    private \ = [];
    private \;
    private \;
    
    public function __construct() {
        \->method = \['REQUEST_METHOD'];
        \->uri = parse_url(\['REQUEST_URI'], PHP_URL_PATH);
        \->uri = str_replace(APP_URL, '', \->uri);
        \->uri = trim(\->uri, '/');
    }
    
    /**
     * Register GET route
     */
    public function get(\, \) {
        \->addRoute('GET', \, \);
    }
    
    /**
     * Register POST route
     */
    public function post(\, \) {
        \->addRoute('POST', \, \);
    }
    
    /**
     * Register PUT route
     */
    public function put(\, \) {
        \->addRoute('PUT', \, \);
    }
    
    /**
     * Register DELETE route
     */
    public function delete(\, \) {
        \->addRoute('DELETE', \, \);
    }
    
    /**
     * Add route
     */
    private function addRoute(\, \, \) {
        \->routes[] = [
            'method' => \,
            'pattern' => \,
            'callback' => \
        ];
    }
    
    /**
     * Dispatch request
     */
    public function dispatch() {
        foreach (\->routes as \) {
            if (\->method !== \['method']) continue;
            
            if (\->matchRoute(\['pattern'], \)) {
                return call_user_func(\['callback'], \);
            }
        }
        
        // Route not found
        Response::json(Response::error('Endpoint not found', HTTP_NOT_FOUND), HTTP_NOT_FOUND);
    }
    
    /**
     * Match route pattern
     */
    private function matchRoute(\, &\) {
        \ = str_replace(':id', '(\d+)', \);
        \ = '^' . \ . '\$';
        
        if (preg_match('/' . \ . '/', \->uri, \)) {
            \ = array_slice(\, 1);
            return true;
        }
        return false;
    }
}
?>

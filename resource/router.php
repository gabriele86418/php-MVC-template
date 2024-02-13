<?php

    define('HTTP_GET', 'GET');
    define('HTTP_POST', 'POST');
    define('HTTP_PUT', 'PUT');
    define('HTTP_DELETE', 'DELETE');

    class Router 
    {
        private static ?Router $instance = null;
        private array $routes;
        private $notFoundCallback;

        private function __construct()
        {
            $this->routes = array();
        }

        public function getRoutesLen()
        {
            return count($this->routes);
        }

        public static function getInstance(): Router
        {
            if (self::$instance === null) 
                self::$instance = new Router();

            return self::$instance;
        }

        public function addRoute(string $method, string $path, array $args, callable $callback)  : void
        {
            $this->routes[] = 
            [
                'method' => $method,
                'args' => $args, 
                'path' => $path, 
                'callback' => $callback
            ];
        }

        public function setNotFoundCallback(callable $notFoundCallback)
        {
            $this->notFoundCallback = $notFoundCallback;
        }

        //  Request args = array_keys($_GET)
        public function handleRequest(string $method, string $path)
        {
            $req_args = $method === HTTP_GET ? array_keys($_GET) : array_keys($_POST); 

            foreach ($this->routes as $route) 
            {
                $res = $this->matchPath($route['path'], $path);

                if ($res['status'] && $route['method'] === $method && self::compare_args($route['args'], $req_args))
                {
                    call_user_func($route['callback'], $res['matches']);
                    return;
                }
            }

            call_user_func($this->notFoundCallback);
        }

        private function matchPath(string $routePath, string $requestPath) : array 
        {
            $pattern = '/^' . str_replace('/', '\/', $routePath) . '\/?$/';
            $status = (bool) preg_match($pattern, $requestPath, $matches);
            return array('status' => $status, 'matches' => $matches);
        }

        private function compare_args($route_args, $req_args)
        {
            $route_args_lwr = array_map('strtolower', $route_args);
            $req_args_lwr = array_map('strtolower', $req_args);

            return $route_args_lwr === $req_args_lwr;
        }
    }


?>
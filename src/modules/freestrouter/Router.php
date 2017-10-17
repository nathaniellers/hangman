<?php
namespace freest\router;

class Router 
{
    private $routes;
    private $routemap;
    private $uri;
    
    public function __construct() 
    {
        $uri = $_SERVER['REQUEST_URI'];
        //echo 'uri1: '.$uri.'<br/>';
        $uri = $this->filterBase($uri);
        $this->uri = $uri;
        //echo 'uri2: '.$uri.'<br/>';        
        $exp = explode('/',$uri);

        // filter all empties
        $routes = array();
        foreach ($exp as $e) {
            if ($e != "") {
                array_push($routes, $e);
            }
        }
        $this->routes = $routes;
        
        //echo 'URI: '.$uri.'<br/>';
        //var_dump($routes);
        
    }
    
    public function route(string $route, $return)
    {
        $this->routemap[] = array(explode('/',$route),$return);
    }
    
    public function get($i = 0)
    {
        if (substr($this->uri,-4) == '.css' || substr($this->uri,-4) == '.png') {
            require $this->uri;
        }
        else {
            if (isset($this->routes[$i])) {
                foreach ($this->routemap as $rm) {
                    if ($rm[0][0] == $this->routes[$i]) {
                        return $rm[1];
                    }
                }
            }
            else {
                return '0';
            }
        }
    }
        
    public function match()  // match the total uri
    {
        echo $this->uri;
    }
    public function getUri($part = 0) {
        if (isset($this->routes[$part])) {
            return $this->routes[$part];
        }
        else {
            return false;
        }
    }
    
    
    // dus ... eerst de eerste twee filteren
    private function filterBase(string $uri): string 
    {
        if (strstr($uri, BASE_ROUTE)) {
            $pos = strpos($uri, BASE_ROUTE);
            //echo $pos.'</br>';
            $pos += strlen(BASE_ROUTE); 
            //echo $pos.'</br>';
            return substr($uri, $pos);
        }
        else {
            return $uri;
        }
    }
    
}

<?php

namespace hangman\mvc\controller;

use Twig_Loader_Filesystem;
use Twig_Environment;

use freest\router\Router as Router;

use hangman\mvc\controller\SingleController;
use hangman\mvc\controller\DuelController;

/* 
 * Controller.php
 */

class Controller 
{
    protected $twig;
    protected $twigarr;
    
    protected $db;
    
    protected $router;
    
    public function __construct() 
    {
        // firing up Twig
        $loader = new Twig_Loader_Filesystem(ROOT_URL.'src/mvc/view/');
        $this->twig = new Twig_Environment($loader, array('cache' => false));
        $this->twigarr_init();    
        // router   
        $this->startRouter();
    }
        
    protected function startRouter() 
    {        
        $router = new Router();
        $router->route('single',    '1');
        $router->route('duel',      '2');
        $this->router = $router;
    }
    private function twigarr_init()
    {        
        $this->twigarr['site_title'] = SITE_TITLE;
        $this->twigarr['www'] = WWW;
    }
    
    
    public function invoke() 
    {
        //var_dump($this->router->routemap);
        //exit(0);
        if ($this->router->get() == '1') {
            $this->single();
        }
        elseif ($this->router->get() == '2') {
            $this->duel();
        }
        else {
            $this->front();
        }
    }
    
    protected function front() {
        $template = $this->twig->load('front.twig');
        echo $template->render($this->twigarr);        
    }
    
    protected function single() {
        $sc = new SingleController();
        $sc->invoke();
    }
    
    protected function duel() {
        $dc = new DuelController();
        $dc->invoke();
    }
    
    protected function warning($message) 
    {
        $template = $this->twig->load('warning.twig');
        $this->twigarr['message'] = $message; 
        echo $template->render($this->twigarr);                  
    }
}

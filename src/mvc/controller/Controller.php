<?php

namespace hangman\mvc\controller;

use Twig_Loader_Filesystem;
use Twig_Environment;

use freest\router\Router as Router;

use hangman\mvc\controller\GameController;

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
        $router->route('game',    '1');
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
            $this->game();
        }
        else {
            $this->front();
        }
    }
    
    protected function front() {
        $template = $this->twig->load('front.twig');
        echo $template->render($this->twigarr);        
    }
    
    protected function game() {
        $sc = new GameController();
        $sc->invoke();
    }
    
}

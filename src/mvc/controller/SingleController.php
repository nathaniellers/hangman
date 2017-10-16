<?php

namespace hangman\mvc\controller;

use hangman\mvc\controller\Controller;
use hangman\mvc\model\SingleModel;

use freest\db\DBC;
use hangman\modules\SingleGame;

/**
 * Description of SingleController
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */

class SingleController extends Controller {

    public function invoke() {
        if ($this->router->getUri(1) && SingleModel::isValidHash($this->router->getUri(1))) {
            $this->game();
        }
        else {
            // start a new game
            $hash = SingleModel::newGame();
            // forward to keyed url
            header("Location: ".WWW."single/".$hash);
        }
    }
    
    protected function game() {
        $hash = $this->router->getUri(1);
        $game_id = SingleModel::gameIdFromHash($hash);
        $game = new SingleGame($game_id);
        $check = SingleModel::checkGuess($game);
        switch ($check['status']) {
            case 'warning':
                $this->twigarr['danger'] = $check['warning'];
        }
        $this->twigarr['game'] = $game;
        $letters = SingleModel::letters($game);
        if ($letters['status'] == '1') {
            SingleModel::endGame($game);
        }
        $this->twigarr['letters'] = $letters;
        $template = $this->twig->load('single/game.twig');
        echo $template->render($this->twigarr);        
    }
    
    
}

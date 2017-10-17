<?php

namespace hangman\mvc\controller;

use hangman\mvc\controller\Controller;
use hangman\mvc\model\GameModel;

use hangman\modules\Game;

/**
 * Description of GameController
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */

class GameController extends Controller {

    public function invoke() {
        if ($this->router->getUri(1) && GameModel::isValidHash($this->router->getUri(1))) {
            $this->game();
        }
        else {
            // start a new game
            $hash = GameModel::newGame();
            // forward to keyed url
            header("Location: ".WWW."game/".$hash);
        }
    }
    
    protected function game() {
        $hash = $this->router->getUri(1);
        $game_id = GameModel::gameIdFromHash($hash);
        $game = new Game($game_id);
        $check = GameModel::checkGuess($game);
        switch ($check['status']) {
            case 'warning':
                $this->twigarr['danger'] = $check['warning'];
        }
        $this->twigarr['game'] = $game;
        $letters = GameModel::letters($game);
        if ($letters['status'] == '1') {
            GameModel::endGame($game);
        }
        $this->twigarr['letters'] = $letters;
        $template = $this->twig->load('game/game.twig');
        echo $template->render($this->twigarr);        
    }
    
    
}

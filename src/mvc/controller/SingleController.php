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
            $hash = SingleModel::generateHash();
            // create new game in db
            $sql = "INSERT INTO single_games (gamehash,game_start) VALUES ('$hash',NOW());";
            $dbc = new DBC();
            $dbc->query($sql) or die("ERROR @ SingleController / invoke - ".$dbc->error());
            // forward to keyed url
            header("Location: ".WWW."single/".$hash);
        }
    }
    
    protected function game() {
        $hash = $this->router->getUri(1);
        $game_id = SingleModel::gameIdFromHash($hash);
        $game = new SingleGame($game_id);
        $this->twigarr['game'] = $game;
        $template = $this->twig->load('single/game.twig');
        echo $template->render($this->twigarr);        
    }
    
    
}

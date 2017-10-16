<?php

namespace hangman\modules;

use freest\db\DBC;
/**
 * Description of SingleGame
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class SingleGame {
    
    private $id;
    private $gamehash;
    private $gameStart;
    private $gameEnded;
    
    public function __construct($id) 
    {
        $dbc = new DBC();
        $sql = "SELECT gamehash,game_start,game_end 
                FROM single_games 
                WHERE id = '$id';";
        $q = $dbc->query($sql) or die("ERROR @ SingleGame - ".$dbc->error());
        $row = $q->fetch_assoc();
        $this->id           = $id;
        $this->gamehash     = $row['gamehash'];
        $this->gameStart    = $row['game_start'];
        $this->gameEnd      = $row['game_end'];
    }
    
    public function id()            { return $this->id;             }
    public function gamehash()      { return $this->gamehash;       }
    public function gameStart()     { return $this->gameStart;    }
    public function gameEnd()       { return $this->gameEnd;      }
}

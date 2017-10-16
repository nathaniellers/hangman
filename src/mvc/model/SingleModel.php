<?php

namespace hangman\mvc\model;

use freest\db\DBC;
/**
 * Description of SingleGameModel
 *
 * @author jfreeman82 <jfreeman@skedaddling.com>
 */
class SingleModel {

    public static function isValidHash($hash): bool
    {
        $dbc = new DBC();
        $sql = "SELECT id FROM single_games WHERE gamehash = '$hash';";
        $q = $dbc->query($sql) or die("ERROR @ SingleGameModel - ".$dbc->error());
        return $q->num_rows > 0;
    }
    
    public static function generateHash(): string
    {
        $hash = self::randomHash();
        while (self::isValidHash($hash)) {
            $hash = self::randomHash();
        }
        return $hash;
    }
    private static function randomHash(): string
    {
        return hash('sha256', random_bytes(20));
    }
    public static function gameIdFromHash($hash): int
    {
        $dbc = new DBC();
        $sql = "SELECT id FROM single_games WHERE gamehash = '$hash';";
        $q = $dbc->query($sql) or die("ERROR @ SingleGameModel - ".$dbc->error());
        return $q->fetch_assoc()['id'];
    }
}

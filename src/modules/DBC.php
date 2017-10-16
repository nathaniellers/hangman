<?php

namespace freest\db;

class DBC {

    public $mysqli = null;

    public function __construct() 
    {   
        $this->mysqli = new \mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

        if ($this->mysqli->connect_errno) {
            echo "Error MySQLi: (". $this->mysqli->connect_errno. ") " . $this->mysqli->connect_error;
            exit();
        }
        $this->mysqli->set_charset("utf8"); 
    }

    public function __destruct() 
    {
        $this->CloseDB();
    }

    public function query($qry) 
    {
        $result = $this->mysqli->query($qry);
        return $result;
    }

    public function runMultipleQueries($qry) 
    {
        $result = $this->mysqli->multi_query($qry);
        return $result;
    }

    public function CloseDB() 
    {
        $this->mysqli->close();
        
    }

    public function clearText($text) 
    {
        $text = trim($text);
        return $this->mysqli->real_escape_string($text);
    }

    public function lastInsertID() 
    {
        return $this->mysqli->insert_id;
    }

    public function totalCount($fieldname, $tablename, $where = "") 
    {
        $q = "SELECT count(".$fieldname.") FROM " 
    .   $tablename . " " . $where;
        
        $result = $this->mysqli->query($q);
        $count = 0;
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $count = $row[0];
            }
        }
        return $count;
    }

    public function error() 
    {
        return $this->mysqli->error;
    }
    
    public function getCon() 
    {
      return $this->mysqli;
    }
}

//$dbc = new DBC();

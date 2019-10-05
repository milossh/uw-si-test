<?php

class DB {
    private $config;
    private $host;
    private $dbname;
    private $dbuser;
    private $dbpassword;
    public $conn;

    /*
    * Database constructor
    */

    public function __construct() {
        // Set config file path, relative to current file directory,
        // and parse it with sections
        $cd = realpath('./../conf/core.ini');
        $this->config = $config = parse_ini_file($cd);
        
        $this->host = $config['host'];
        $this->dbname = $config['name'];
        $this->dbuser = $config['user'];
        $this->dbpassword = $config['password'];
    }

    public function get_connection() {

        $this->conn = null;

        try {
            $dbconstr = 'mysql:';
            $dbconstr .= 'host=' . $this->host . ';';
            $dbconstr .= 'dbname=' . $this->dbname . ';';
            $dbconstr .= 'charset=utf8;';

            $this->conn = new PDO( $dbconstr, $this->dbuser, $this->dbpassword );
        } catch(PDOException $e) {
            // Write something to log file here, and possibly return error
        }

        return $this->conn;
    }

    public function endConnection() {
        $this->conn = null;
    }
}
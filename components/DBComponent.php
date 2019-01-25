<?php

defined('ABS_PATH') or die;

class DBComponent
{
    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance))
        {
            //$config = include ABS_PATH . '/config.php';
            include_once  ABS_PATH .'/db.cfg.php'; 

            // $host   = ((defined('DB_HOST')) ? DB_HOST : 'localhost');
            // $port   = ((defined('DB_PORT')) ? DB_PORT : 3306);
            // $dbname = ((defined('DB_NAME')) ? DB_NAME : 'admin');
            // $user   = ((defined('DB_USER')) ? DB_USER : 'root');
            // $pass   = ((defined('DB_PASS')) ? DB_PASS : '');

            $host   = 'localhost';
            $port   = 8888;
            $dbname = 'reprint';
            $user   = 'root';
            $pass   = 'root';

            try {    
                $db = new PDO(
                    'mysql:host='.$host.';port='.$port.';dbname='.$dbname.';charset=utf8',
                    $user,
                    $pass 
                );                

                self::$instance = $db;
            }
            catch (PDOException $e) {
                myLog("Error!: " . $e->getMessage(), 'pdo');
                exit();
            }

        }
        return self::$instance;
    }

    public static function close()
    {
        self::$instance = null;        
    }

    private function __clone()
    {

    }

    private function __construct()
    {

    }

    

}
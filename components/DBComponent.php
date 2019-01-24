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
            try {    
                $db = new PDO(
                    'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8',
                    DB_USER,
                    DB_PASS 
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
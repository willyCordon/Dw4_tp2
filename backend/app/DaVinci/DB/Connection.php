<?php
namespace DaVinci\DB;

use PDO;

class Connection
{
    private static $db = null;
    private function __construct(){}
    
    /**
    * Retorna la conexión a la base de datos
    */
    
    public static function getConnection(){
        if(Connection::$db === null){
            $db_host = "localhost";
            $db_user = "root";
            $db_pass = "";
            $db_base = "DW4_SOBRE_FUTBOL";
            $db_charset = "utf8mb4";
            $db_dsn = "mysql:host={$db_host}; dbname={$db_base};charset={$db_charset}";
            
            Connection::$db = new PDO($db_dsn, $db_user, $db_pass);
        }
        return Connection::$db;
    }
}
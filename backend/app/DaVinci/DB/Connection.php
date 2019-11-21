<?php
namespace DaVinci\DB;

use PDO;
/**
 * Esta clase permite manejar PDO en modo Singleton.
 */
class Connection
{
    private static $db = null;
    /** Constructor privado, para asegurarnos de que no instancien libremente esta clase. */
    private function __construct(){}
    
	/**
	 * Los métodos estáticos pueden llamarse _directamente_ desde la clase.
	 * Un detalle, los métodos estáticos no tienen acceso a $this.
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
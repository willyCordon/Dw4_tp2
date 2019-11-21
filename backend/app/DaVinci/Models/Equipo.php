<?php

namespace DaVinci\Models;

use DaVinci\DB\Connection;
use PDO;

class Equipo extends Modelo
{
    protected $table = "equipos";
    protected $primaryKey = "id";
        /** @var array Lista de atributos */
    protected $attributes = ['id_equipo', 'nombre', 'puntos', 'apodo', 'entrenador', 'imagen'];
    
    protected $id_equipo;
    protected $nombre;
    protected $puntos;
    protected $apodo;
    protected $entrenador;
    protected $imagen;
    
/**
* Retorna un array con todas las equipos
* en orden por puntaje
* @return array
*/        
    public function getLimitOrder(){
        $db = Connection::getConnection();
        $query = "SELECT * FROM " . $this->table . " ORDER BY puntos DESC LIMIT 3";
        $stmt = $db->prepare($query);
        $stmt->execute([]);
        
        $salida = [];
        
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new static;
            $obj->loadDataFromArray($fila);
            $salida[] = $obj;
        }
        
        return $salida;
    }


    public function getAllOrder(){
        $db = Connection::getConnection();
        $query = "SELECT * FROM " . $this->table . " ORDER BY puntos DESC";
        $stmt = $db->prepare($query);
        $stmt->execute([]);
        
        $salida = [];
        
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new static;
            $obj->loadDataFromArray($fila);
            $salida[] = $obj;
        }
        
        return $salida;
    }

/**
* Suma los puntos obtenidos
* en el puntaje de una equipo
*
* @param int $num
* @param int $equipo
* @return bool
*/    
    public function sumarPuntos($num, $equipo){
        $db = Connection::getConnection();
        $query = "UPDATE " . $this->table . " SET puntos = puntos + :num  WHERE id_equipo = :equipo ";
        $stmt = $db->prepare($query);
        $rta = $stmt->execute([
            'num'        => $num,
            'equipo'       => $equipo,
        ]);
        return $rta;
    }
      
    
/*=================================================
                GETTERS Y SETTERS
==================================================*/      
    
 /**
* Setea el $id
*
* @param int $id
*/    

    public function setId($id){
        if(!is_numeric($id)){
            throw new Exception("El ID debe ser un número. El valor ingresado es un " . gettype($id) . ".");
        }
             $this->id_equipo = $id;
    }
    
 /**
 * Retorna el $id
 * 
* @return int $id
 */
 
     public function getId(){
         return $this->id_equipo;
     }  
    
  /*--------------------------------------------------------------*/        
 /**
* Setea el $nombre
*
* @param string $nombre
*/    

    public function setNombre($nombre){
        if(!is_string($nombre)){
            throw new Exception("El nombre debe ser un string. El valor ingresado es un " . gettype($nombre) . ".");
        }
             $this->nombre = $nombre;
    }    
    
 /**
 * Retorna el $nombre
 * 
* @return string $nombre
 */
 
     public function getNombre(){
         return $this->nombre;
     }
    
 /*--------------------------------------------------------------*/        
  
  /**
* Setea el $puntos
*
* @param int $puntos
*/    

    public function setPuntos($puntos){
        if(!is_numeric($puntos)){
            throw new Exception("Los puntos debe ser un número. El valor ingresado es un " . gettype($puntos) . ".");
        }
             $this->puntos = $puntos;
    }
    
 /**
 * Retorna el $puntos
 * 
* @return int $puntos
 */
 
     public function getPuntos(){
         return $this->puntos;
     }    
    
 /*--------------------------------------------------------------*/        
 /**
* Setea el $apodo
*
* @param string $apodo
*/    

    public function setApodo($apodo){
        if(!is_string($apodo)){
            throw new Exception("La apodo debe ser un string. El valor ingresado es un " . gettype($apodo) . ".");
        }
             $this->apodo = $apodo;
    }    
    
 /**
 * Retorna el $apodo
 * 
* @return string $apodo
 */
 
     public function getApodo(){
         return $this->apodo;
     }
    
 /*--------------------------------------------------------------*/
       
 /**
* Setea el $entrenador
*
* @param string $entrenador
*/    

    public function setEntrenador($entrenador){
        if(!is_string($entrenador)){
            throw new Exception("El entrenador debe ser un string. El valor ingresado es un " . gettype($entrenador) . ".");
        }
             $this->entrenador = $entrenador;
    }    
    
 /**
 * Retorna el $entrenador
 * 
* @return string $entrenador
 */
 
     public function getEntrenador(){
         return $this->entrenador;
     }
    
 /*--------------------------------------------------------------*/    
    
 /**
* Setea el $imagen
*
* @param string $imagen
*/    

    public function setImagen($imagen){
        if(!is_string($imagen)){
            throw new Exception("El imagen debe ser un string. El valor ingresado es un " . gettype($imagen) . ".");
        }
             $this->imagen = $imagen;
    }    
    
 /**
 * Retorna el $imagen
 * 
* @return string $imagen
 */
 
     public function getImagen(){
         return $this->imagen;
     }    
    
}
<?php

namespace DaVinci\Models;

use DaVinci\DB\Connection;
use PDO;

class Casa extends Modelo
{
    protected $table = "equipo";
    protected $primaryKey = "id";
        /** @var array Lista de atributos */
    protected $attributes = ['id_casa', 'nombre', 'puntos', 'mascota', 'fundador', 'imagen'];
    
    protected $id_casa;
    protected $nombre;
    protected $puntos;
    protected $mascota;
    protected $fundador;
    protected $imagen;
    
/**
* Retorna un array con todas las equipo
* en orden por puntaje
* @return array
*/        

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
* en el puntaje de una casa
*
* @param int $num
* @param int $casa
* @return bool
*/    
    public function sumarPuntos($num, $casa){
        $db = Connection::getConnection();
        $query = "UPDATE " . $this->table . " SET puntos = puntos + :num  WHERE id_casa = :casa ";
        $stmt = $db->prepare($query);
        $rta = $stmt->execute([
            'num'        => $num,
            'casa'       => $casa,
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
             $this->id_casa = $id;
    }
    
 /**
 * Retorna el $id
 * 
* @return int $id
 */
 
     public function getId(){
         return $this->id_casa;
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
* Setea el $mascota
*
* @param string $mascota
*/    

    public function setMascota($mascota){
        if(!is_string($mascota)){
            throw new Exception("La mascota debe ser un string. El valor ingresado es un " . gettype($mascota) . ".");
        }
             $this->mascota = $mascota;
    }    
    
 /**
 * Retorna el $mascota
 * 
* @return string $mascota
 */
 
     public function getMascota(){
         return $this->mascota;
     }
    
 /*--------------------------------------------------------------*/
       
 /**
* Setea el $fundador
*
* @param string $fundador
*/    

    public function setFundador($fundador){
        if(!is_string($fundador)){
            throw new Exception("El fundador debe ser un string. El valor ingresado es un " . gettype($fundador) . ".");
        }
             $this->fundador = $fundador;
    }    
    
 /**
 * Retorna el $fundador
 * 
* @return string $fundador
 */
 
     public function getFundador(){
         return $this->fundador;
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
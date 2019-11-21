<?php

namespace DaVinci\Models;

use DaVinci\Auth\Contracts\Autenticable;
use DaVinci\DB\Connection;
use PDO;


class Usuario extends Modelo implements Autenticable
{
    protected $table = "usuarios";
    protected $primaryKey = "id";
    protected $attributes = ['id', 'email', 'clave', 'nombre', 'apellido', 'fecha_alta', 'avatar', 'equipo', 'fecha_nacimiento'];
    
    protected $id;
    protected $email;
    protected $clave;
    protected $nombre;
    protected $apellido; 
    protected $estado; 
    protected $fecha_alta; 
    protected $avatar; 
    protected $equipo; 
    protected $fecha_nacimiento; 
    
//public function getByPk($pk)
//{
//    $db = Connection::getConnection();
//    $query = "SELECT usuarios.nombre, apellido, email, clave, equipo.nombre as equipo, avatar, fecha_nacimiento FROM usuarios LEFT JOIN equipo ON usuarios.equipo = equipo.id_equipo WHERE id = ?";
//    $stmt = $db->prepare($query);
//    $stmt->execute([$pk]);
//    
//    $fila = $stmt->fetch(PDO::FETCH_ASSOC);
//    
//    $this->loadDataFromArray($fila);
//}  
//    
        
/**
* Carga los datos de un usuario buscándolo por su $email
*
* @param string $email
* @return bool
*/    
    
public function traerPorEmail($email):bool{
    $db = Connection::getConnection();
    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);
    $f = $stmt->fetch(PDO::FETCH_ASSOC);
    if($f){
        $this->loadDataFromArray($f);
        return true;
    }else{
        return false;
    }
}    
    

 /*=================================================
                GETTERS Y SETTERS
==================================================*/    

    
    
    /*--------------------------------------------------------------*/   
 /**
* Setea el $id
*
* @param int $id
*/    

    public function setId($id){
        if(!is_numeric($id)){
            throw new Exception("El ID debe ser un número. El valor ingresado es un " . gettype($id) . ".");
        }
             $this->id = $id;
    }
    
 /**
 * Retorna el $id
 * 
* @return int $id
 */
 
     public function getId(){
         return $this->id;
     }  
    
/*--------------------------------------------------------------*/    
    
 /**
* Setea el $email
*
* @param string $email
* @throws Exception
*/

    public function setEmail($email){
        if(!is_string($email)){
            throw new Exception("El email debe ser un string. El valor ingresado es un " . gettype($email) . ".");
        }
        $this->email = $email;
    }


/**
* Retorna el email
*/

    public function getEmail(){
        return $this->email;
    }

 /*--------------------------------------------------------------*/

/**
* Setea el $clave
*
* @param string $clave
* @throws Exception
*/

    public function setClave($clave){
        if(!is_string($clave)){
            throw new Exception("La clave debe ser un string. El valor ingresado es un " . gettype($clave) . ".");
        }
        $this->clave = $clave;
    }


/**
* Retorna la clave
*/

    public function getClave(){
        return $this->clave;
    }   
    
    
  
/*--------------------------------------------------------------*/     

/**
* Setea el $nombre
*
* @param string $nombre
* @throws Exception
*/

    public function setNombre($nombre){
        if(!is_string($nombre)){
            throw new Exception("El nombre debe ser un string. El valor ingresado es un " . gettype($nombre) . ".");
        }
        $this->nombre = $nombre;
    }

/**
* Retorna el nombre
* 
* @return string nombre
*/

    public function getNombre(){
        return $this->nombre;
    }       

    
/*--------------------------------------------------------------*/
    
/**
* Setea el $apellido
*
* @param string $apellido
* @throws Exception
*/

    public function setApellido($apellido){
        if(!is_string($apellido)){
            throw new Exception("El Apellido debe ser un string. El valor ingresado es un " . gettype($apellido) . ".");
        }
        $this->apellido = $apellido;
    }


/**
* Retorna el apellido
* @return string
*/

    public function getApellido(){
        return $this->apellido;
    }     
    
 /*--------------------------------------------------------------*/
    
/**
* Setea el $fecha_alta
*
* @param string $fecha_alta
*/

    public function setFecha_alta($fecha_alta){
        $this->fecha_alta = $fecha_alta;
    }


/**
* Retorna el fecha_alta
* @return string
*/

    public function getFecha_alta(){
        return $this->fecha_alta;
    }     
       
  /*--------------------------------------------------------------*/
    
/**
* Setea el $avatar
*
* @param string $avatar
*/

    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }


/**
* Retorna el avatar
* @return string
*/

    public function getAvatar(){
        return $this->avatar;
    }        
 
  /*--------------------------------------------------------------*/
    
/**
* Setea el $equipo
*
* @param string $equipo
*/

    public function setEquipo($equipo){
        $this->equipo = $equipo;
    }


/**
* Retorna el equipo
* return string
*/

    public function getEquipo(){
        return $this->equipo;
    }
    
/*--------------------------------------------------------------*/
    
/**
* Setea el $fecha_nacimiento
*
* @param string $fecha_nacimiento
*/

    public function setFecha_nacimiento($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }


/**
* Retorna el fecha_nacimiento
* @return string 
*/

    public function getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }     
    
    
}
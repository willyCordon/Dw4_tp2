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
    
/**
 * 
 * ************* GETTER Y SETTER *******************
 * 
 */


    public function setId($id){
        if(!is_numeric($id)){
            throw new Exception("El ID debe ser un número. El valor ingresado es un " . gettype($id) . ".");
        }
             $this->id = $id;
    }
    

 
     public function getId(){
         return $this->id;
     }  
    


    public function setEmail($email){
        if(!is_string($email)){
            throw new Exception("El email debe ser un string. El valor ingresado es un " . gettype($email) . ".");
        }
        $this->email = $email;
    }



    public function getEmail(){
        return $this->email;
    }



    public function setClave($clave){
        if(!is_string($clave)){
            throw new Exception("La clave debe ser un string. El valor ingresado es un " . gettype($clave) . ".");
        }
        $this->clave = $clave;
    }


    public function getClave(){
        return $this->clave;
    }   
    
    


    public function setNombre($nombre){
        if(!is_string($nombre)){
            throw new Exception("El nombre debe ser un string. El valor ingresado es un " . gettype($nombre) . ".");
        }
        $this->nombre = $nombre;
    }



    public function getNombre(){
        return $this->nombre;
    }       

    


    public function setApellido($apellido){
        if(!is_string($apellido)){
            throw new Exception("El Apellido debe ser un string. El valor ingresado es un " . gettype($apellido) . ".");
        }
        $this->apellido = $apellido;
    }


    public function getApellido(){
        return $this->apellido;
    }     
    


    public function setFecha_alta($fecha_alta){
        $this->fecha_alta = $fecha_alta;
    }


    public function getFecha_alta(){
        return $this->fecha_alta;
    }     
       


    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }



    public function getAvatar(){
        return $this->avatar;
    }        


    public function setEquipo($equipo){
        $this->equipo = $equipo;
    }



    public function getEquipo(){
        return $this->equipo;
    }
    


    public function setFecha_nacimiento($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }



    public function getFecha_nacimiento(){
        return $this->fecha_nacimiento;
    }     
    
    
}
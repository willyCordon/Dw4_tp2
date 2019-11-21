<?php
namespace DaVinci\Models;

use DaVinci\DB\Connection;
use PDO;

class Publicacion extends Modelo
{
    protected $table = "publicaciones";
    protected $primaryKey = "id";
        /** @var array Lista de atributos */    
    protected $attributes = ['id', 'texto', 'privacidad', 'dia', 'hora', 'imagen', 'usuario'];
    
    protected $id;
    protected $texto;
    protected $privacidad;
    protected $dia;
    protected $hora;
    protected $usuario;
    protected $imagen;

/**
*
* Devuelve todas las publicaciones
* de un usuario
*
* @param int $user
* @return array $salida
*
*/    
public function getAllByUser($user){
        $db = Connection::getConnection();
        $query = "SELECT * FROM publicaciones WHERE usuario = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$user]);
        
        $salida = [];
        
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new static;
            $obj->loadDataFromArray($fila);
            $salida[] = $obj;
        }
        
        return $salida;    
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
* Setea el $texto
*
* @param string $texto
*/    

    public function setTexto($texto){
        if(!is_string($texto)){
            throw new Exception("El texto debe ser un string. El valor ingresado es un " . gettype($texto) . ".");
        }
             $this->texto = $texto;
    }    
    
 /**
 * Retorna el $texto
 * 
* @return string $texto
 */
 
     public function getTexto(){
         return $this->texto;
     }       
    
    
  /*--------------------------------------------------------------*/        
 /**
* Setea el $privacidad
*
* @param string $privacidad
*/    

    public function setPrivacidad($privacidad){
        if(!is_string($privacidad)){
            throw new Exception("El privacidad debe ser un string. El valor ingresado es un " . gettype($privacidad) . ".");
        }
             $this->privacidad = $privacidad;
    }    
    
 /**
 * Retorna el $privacidad
 * 
* @return string $privacidad
 */
 
     public function getPrivacidad(){
         return $this->privacidad;
     }   
    
    
 /*--------------------------------------------------------------*/        
 /**
* Setea el $dia
*
* @param string $dia
*/    

    public function setDia($dia){
        if(!is_string($dia)){
            throw new Exception("El dia debe ser un string. El valor ingresado es un " . gettype($dia) . ".");
        }
             $this->dia = $dia;
    }    
    
 /**
 * Retorna el $dia
 * 
* @return string $dia
 */
 
     public function getDia(){
         return $this->dia;
     }
    
 /*--------------------------------------------------------------*/        
 /**
* Setea el $hora
*
* @param string $hora
*/    

    public function setHora($hora){
        if(!is_string($hora)){
            throw new Exception("La hora debe ser un string. El valor ingresado es un " . gettype($hora) . ".");
        }
             $this->hora = $hora;
    }    
    
 /**
 * Retorna el $hora
 * 
* @return string $hora
 */
 
     public function getHora(){
         return $this->hora;
     }     
         
  
  /*--------------------------------------------------------------*/        
 /**
* Setea el $usuario
*
* @param int $usuario
*/    

    public function setUsuario($usuario){
        if(!is_numeric($id)){
            throw new Exception("El usuario debe ser un número. El valor ingresado es un " . gettype($usuario) . ".");
        }        
             $this->usuario = $usuario;
    }    
    
 /**
 * Retorna el $usuario
 * 
* @return int $usuario
 */
 
     public function getUsuario(){
         return $this->usuario;        
     }     
    
   /*--------------------------------------------------------------*/        
 /**
* Setea el $imagen
*
* @param string $imagen
*/    

    public function setImagen($imagen){
        if(!is_string($hora)){
            throw new Exception("La imagen debe ser un string. El valor ingresado es un " . gettype($imagen) . ".");
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
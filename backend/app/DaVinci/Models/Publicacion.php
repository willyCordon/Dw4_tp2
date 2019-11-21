<?php
namespace DaVinci\Models;

use DaVinci\DB\Connection;
use PDO;

class Publicacion extends Modelo
{
    protected $table = "publicaciones";
    protected $primaryKey = "id";  
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
    
  

    public function setTexto($texto){
        if(!is_string($texto)){
            throw new Exception("El texto debe ser un string. El valor ingresado es un " . gettype($texto) . ".");
        }
             $this->texto = $texto;
    }    
    

 
     public function getTexto(){
         return $this->texto;
     }       
    
    


    public function setPrivacidad($privacidad){
        if(!is_string($privacidad)){
            throw new Exception("El privacidad debe ser un string. El valor ingresado es un " . gettype($privacidad) . ".");
        }
             $this->privacidad = $privacidad;
    }    
    

 
     public function getPrivacidad(){
         return $this->privacidad;
     }   
    
    
  

    public function setDia($dia){
        if(!is_string($dia)){
            throw new Exception("El dia debe ser un string. El valor ingresado es un " . gettype($dia) . ".");
        }
             $this->dia = $dia;
    }    
    

     public function getDia(){
         return $this->dia;
     }
    
  

    public function setHora($hora){
        if(!is_string($hora)){
            throw new Exception("La hora debe ser un string. El valor ingresado es un " . gettype($hora) . ".");
        }
             $this->hora = $hora;
    }    
    

 
     public function getHora(){
         return $this->hora;
     }     
         
  
  

    public function setUsuario($usuario){
        if(!is_numeric($id)){
            throw new Exception("El usuario debe ser un número. El valor ingresado es un " . gettype($usuario) . ".");
        }        
             $this->usuario = $usuario;
    }    
    
 
 
     public function getUsuario(){
         return $this->usuario;        
     }     
    


    public function setImagen($imagen){
        if(!is_string($hora)){
            throw new Exception("La imagen debe ser un string. El valor ingresado es un " . gettype($imagen) . ".");
        }        
             $this->imagen = $imagen;
    }    
    

 
     public function getImagen(){
         return $this->imagen;        
     }     
       
    
}
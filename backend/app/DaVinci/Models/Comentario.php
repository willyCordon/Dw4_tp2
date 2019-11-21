<?php
namespace DaVinci\Models;

use DaVinci\DB\Connection;
use PDO;



class Comentario extends Modelo
{
    protected $table = "comentarios";
    protected $primaryKey = "id";
    protected $attributes = ['id', 'dia', 'hora', 'publicacion', 'usuario', 'texto'];
    
    protected $id;
    protected $dia;
    protected $hora;
    protected $publicacion;
    protected $usuario;
    protected $texto;
    
/**
* Retorna todos los comentarios vinculados a una sola publicación
*
* @param int $id
* @return array|static
*/        

    public function comentariosPorPub($id){
        $db = Connection::getConnection();
        $query = "SELECT * FROM comentarios WHERE publicacion = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
        
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
    
  

    public function setPublicacion($publicacion){
             $this->publicacion = $publicacion;
    }    
    

 
     public function getPublicacion(){
        return $this->publicacion;       
     } 
    

    public function setUsuario($usuario){
             $this->usuario = $usuario;
    }    

 
     public function getUsuario(){
        return $this->usuario;     
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
    
    
    
    
}
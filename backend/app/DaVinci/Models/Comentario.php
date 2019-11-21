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
* Setea el $publicacion
*
* @param string $publicacion
*/    

    public function setPublicacion($publicacion){
             $this->publicacion = $publicacion;
    }    
    
 /**
 * Retorna el $publicacion
 * 
* @return string $publicacion
 */
 
     public function getPublicacion(){
        return $this->publicacion;       
     } 
    
  /*--------------------------------------------------------------*/        
 /**
* Setea el $usuario
*
* @param string $usuario
*/    

    public function setUsuario($usuario){
             $this->usuario = $usuario;
    }    
    
 /**
 * Retorna el $usuario
 * 
* @return string $usuario
 */
 
     public function getUsuario(){
        return $this->usuario;     
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
    
    
    
    
}
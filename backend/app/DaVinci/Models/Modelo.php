<?php

namespace DaVinci\Models;

use DaVinci\DB\Connection;
use JsonSerializable;
use PDO;

class Modelo implements JsonSerializable
{
    /** @var string El nombre de la tabla para el modelo. */
    protected $table = "";
    /** @var string El campo de la PK. */
    protected $primaryKey = "id";
    /** @var array Los campos de la tabla del modelo. */
    protected $attributes = [];
    /** @var array Los campos a excluir del JSON en el jsonSerialize. */
    protected $jsonExclude = [];

    // protected $attributesValues = [];
    // function __set()
    // function __get()

    /**
     * Especifica la data que se convierte a JSON.
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // Por defecto, serializamos todos los atributos.
        $data = [];
        foreach($this->attributes as $attribute) {
            // Verificamos que este atributo no esté excluído.
            if(!in_array($attribute, $this->jsonExclude)) {
                $data[$attribute] = $this->{$attribute};
            }
        }
        return $data;
    }
    
    /**
     * Retorna un array con todos los items de la tabla.
     *
     * @return array|static
     */
    public function getAll()
    {
        $db = Connection::getConnection();
        $query = "SELECT * FROM " . $this->table;
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $salida = [];
        
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $obj = new static;
            
            $obj->loadDataFromArray($fila);
            
            $salida[] = $obj;
        }
        
        return $salida;
    }
    
    /**
     * Busca el registro por su $pk.
     *
     * @param mixed $pk
     */
    public function getByPk($pk)
    {
        $db = Connection::getConnection();
        $query = "SELECT * FROM " . $this->table .
            " WHERE " . $this->primaryKey . " = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);
        
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->loadDataFromArray($fila);
    }

    /**
     * Inserta los $data en la $tabla.
     *
     * @param array $data Array con los valores para insertar. Los índices deben coincidir con los campos de la tabla.
     * @return bool
     */
    public function create($data)
    {
        $db = Connection::getConnection();
        
        $insertFields = implode(', ', $this->getAttributesForQuery());
        $holders = implode(', ', $this->getAttributesHoldersForQuery());
        
        $query = "INSERT INTO " . $this->table . " (" . $insertFields . ")
                VALUES (" . $holders . ")";
        
        $insertData = $this->filterDataForInsert($data);
        
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($insertData);
        
        if($exito) {
            // $this->id_producto = $db->lastInsertId();
            $this->{$this->primaryKey} = $db->lastInsertId();
            $this->loadDataFromArray($insertData);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Elimina un registro de la base.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $db = Connection::getConnection();
        $query = "DELETE FROM " . $this->table . "
                  WHERE " . $this->primaryKey . " = ?";
        $stmt = $db->prepare($query);
        return $stmt->execute([$id]);
    }

    /**
     * Edita todos los datos de un registro.
     *
     * @param array $fila
     */
    
    public function edit($data){
    $db = Connection::getConnection();
    $attr = $this->getAttributesForQuery();
    $cuerpoQuery = ' SET ';
    foreach($attr as $at => $a){
        if($at != sizeOf($attr)){
            $cuerpoQuery .= $a . "= :" . $a . ", ";
        }else{
            $cuerpoQuery .= $a . "= :" . $a . " ";
        }
    }
    $cuerpoQuery .= "WHERE " . $this->primaryKey . " = :" . $this->primaryKey; 
    
    
    $query = "UPDATE " . $this->table . $cuerpoQuery;
    
    $stmt = $db->prepare($query);
    $rta = $stmt->execute($data);    
        
    return $rta;   
    }
    
    public function test($data){
        $db = Connection::getConnection();
        $keys= $this->dameKeys($data);
        $cuerpoQuery = " SET ";
           foreach($keys as $at => $a){
                if($at < sizeOf($keys) - 1){
                    $cuerpoQuery .= $a . "= :" . $a . ", ";
                }else{
                    $cuerpoQuery .= $a . "= :" . $a . " ";
                }
            }
        $cuerpoQuery .= "WHERE " . $this->primaryKey . " = :" . $this->primaryKey; 
        $query = "UPDATE " . $this->table . $cuerpoQuery;
        $stmt = $db->prepare($query);
        $rta = $stmt->execute($data);    

        return $rta;        
    }

    public function dameKeys($data){
        $keys = [];
        while($key = current($data)){
            $keys[] = key($data);
            next($data);
        }
        return $keys;
    }
    
    
    /**
     * Retorna los $attributes sin la $primaryKey.
     *
     * @return array
     */
    protected function getAttributesForQuery()
    {
        return array_filter($this->attributes, function($item) {
            // Si el $item es la PK, lo ignoramos.
            return $item != $this->primaryKey;
        });
    }
    
    /**
     * Retorna los $attributes con un ":" adelante para 
     * usar como holders.
     *
     * @return array
     */
    protected function getAttributesHoldersForQuery()
    {
        return array_map(function($item) {
            // Si el $item es la PK, lo ignoramos.
            return ':' . $item;
        }, $this->getAttributesForQuery());
    }

    /**
     * Obtiene de $data los datos para el insert.
     *
     * @param array $data
     * @return array
     */
    protected function filterDataForInsert($data)
    {
        $salida = [];
        
        // Recorremos los atributos del Modelo, y
        // de $data sacamos solo los valores que
        // pertenezcan a estos atributos.
        foreach($this->attributes as $attr) {
            if($attr != $this->primaryKey) {
                $salida[$attr] = $data[$attr];
            }
        }
        
        return $salida;
    }
    
    /**
     * Carga los datos a las propiedades.
     *
     * @param array $fila
     */
    public function loadDataFromArray($fila)
    {
        // Recorremos los $attributes y asignamos
        // los valores.
        foreach($this->attributes as $attr) {
            // ej:
            // $attr = 'nombre';
            // $this->nombre = $fila['nombre'];
            if(isset($fila[$attr])) {
                $this->{$attr} = $fila[$attr];
            }
        }
    }
}











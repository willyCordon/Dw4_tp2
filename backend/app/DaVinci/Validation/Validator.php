<?php
namespace DaVinci\Validation;

/**
* Clase que validará los datos ingresados del formulario
*/

class Validator
{
/**
* @var array Datos a validar
*/
    protected $data = [];
    
/**
* @var array Reglas de validación
*/
    protected $reglas = [];
    
/**
* @var array Errores de validación.
*/
    protected $errores = [];
    
    
/**
* Crea el validador de datos
*
* @param array $data Los datos a validar
* @param array $reglas Reglas a aplicar a los datos
*/
    
    public function __construct($data, $reglas)
    {
        $this->data = $data;
        $this->reglas = $reglas;
        $this->validate();
    }

    
/**
* Ejecuta las validaciones
*/
    
    public function validate()
    {
        foreach($this->reglas as $campo => $listaReglas){
            foreach($listaReglas as $regla){
                $this->aplicarRegla($campo, $regla);
            }
        }
    }
    
/**
* Aplica una $regla de validación al $campo ingresado
*
* @param string $campo
* @param string $regla
*/
    
    public function aplicarRegla($campo, $regla)
    {
        // VERIFICO EL TIPO DE REGLA
            if(strpos($regla, ':')){
                list($nombre, $dato) = explode(':', $regla);

                // NOMBRE DEL METODO
                    $metodo = "_" . $nombre;
                    if(!method_exists($this, $metodo)) {
                        throw new Exception("No existe la regla de validación" . $nombre);
                    }

                // EJECUTO LA REGLA
                    $this->{$metodo}($campo, $dato);
            }else{
                // METODO
                    $metodo = "_" . $regla;
                // VERIFICO SI EXISTE
                    if(!method_exists($this, $metodo)) {
                        throw new Exception("No existe la regla de validación" . $nombre);
                    } 
                // EJECUTO LA REGLA
                    $this->{$metodo}($campo);
            }
    }
    
/**
* Indica si la validación fue exitosa
*
* @return bool
*/    
    
    public function passes()
    {
        return count($this->errores) === 0;
    }
    
/**
* Retorna el array de errores
*
* @return array
*/
    
    public function getErrores()
    {
        return $this->errores; 
    }
    
/**
* Genera un mensaje de error
*
* @params string $campo El nombre del campo
* @params string $error El mensaje de error
*/    
    
public function addError($campo, $error)
{
    if(!isset($this->errores[$campo])){
        $this->errores[$campo] = [];
    }
    $this->errores[$campo][] = $error;
}
 
    
    
    
 /*=================================================
                VALIDACIONES
==================================================*/      
    
/**
* Verifica que el valor del campo no esté vacío.
*
* @param string $campo
* @return bool
*/
    
protected function _required($campo)
{
    $valor = $this->data[$campo];
    if(empty($valor)){
        $this->addError($campo, 'La propiedad ' . $campo . ' no puede estar vacia.');
        return false;
    }
    return true;
}

/**
* Verifica que el valor del campo tenga un mínimo de caracteres
*
* @param string $campo 
* @param int $min
* @return bool
*/
protected function _min($campo, $min)
{
    $valor = $this->data[$campo];
    if(strlen($valor) < $min){
        $this->addError($campo, 'La propiedad ' . $campo . ' debe tener al menos ' . $min . " caracteres.");
        return false;
    }
    return true;
}

/**
* Verifica que el valor del campo cumpla con un máximo de caracteres
*
* @param string $campo
* @param int $min
* @return bool
*/
    
protected function _max($campo, $max)
{
    $valor = $this->data[$campo];
    if(strlen($valor) > $max){
        $this->addError($campo, 'La propiedad ' . $campo . ' no debe tener más de ' . $max . " caracteres.");
        return false;
    }
    return true;
}
    
    
    

/**
* Verifica que el valor ingresado sea un número
* 
* @param int $campo
* @return bool
*/

protected function _numeric($campo)
{
    $valor = $this->data[$campo];
    if(!is_numeric($valor)){
        $this->addError($campo, 'La propiedad ' . $campo . ' debe ser un número.');
        return false;
    }
    return true;
}    
    

} //FINAL DE LA CLASE


<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Usuario;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Validation\Validator;

/**
* Controlador encargado de
* las peticiones de la
* tabla de usuarios
*/  
class APIUsuariosController
{

/**
* Devuelve los datos
* de un usuario
* buscándolo por su Id
*/          
public function traerPorId(){
    $parameters = Route::getUrlParameters();
    $id = $parameters['id'];
    
    $user = new Usuario;
    $user->getByPk($id);
    
    View::renderJson($user);
}
    
/**
* Guarda una publicación nueva
*/      
public function grabar(){
    // DATOS RECIBIDOS
        $rawData = file_get_contents('php://input');
        $data = json_decode($rawData, true);
        $data['estado'] =  1;
        $data['fecha_alta'] =  date("Y-m-d H:i:s");
        $data['clave'] =  password_hash($data['clave'], PASSWORD_DEFAULT);

    // IMAGEN
        $path = '../../frontend/img/avatares/';
        if($data['avatar'] != null){
            $imagen64 = $data['avatar'];
            list($imagenTipo, $imagenCodigo) = explode(',', $imagen64);
            // NOMBRE
                $nombreImagen = date('Ymd_His');
            // EXTENSION
                if(strpos($imagenTipo, 'image/png')) {
                    $nombreImagen .= ".png";
                } else if(strpos($imagenTipo, 'image/pjpeg') || strpos($imagenTipo, 'image/jpeg')) {
                    $nombreImagen .= ".jpg";
                } else if(strpos($imagenTipo, 'image/gif')) {
                    $nombreImagen .= ".gif";
                } else if(strpos($imagenTipo, 'image/webp')) {
                    $nombreImagen .= ".webp";
                }
        // DECODIFICAR
           $imagenDecodificada = base64_decode($imagenCodigo); 
        // CREO EL ARCHIVO
            file_put_contents($path . $nombreImagen, $imagenDecodificada);
        // DATA
        $data['avatar'] = $nombreImagen;
    }
    
    // VALIDAR DATOS
        $validar = new Validator($data, [
            'nombre' => ['required', 'min:3'],
            'apellido' => ['required'],
            'email' => ['required'],
            'clave' => ['required', 'min:3'],
            'equipo' => ['required'],
            'fecha_nacimiento' => ['required'],
        ]);
        if(!$validar->passes()){
           View::renderJson([
            'status'    => 2,
            'msj'       => $validar->getErrores(),   
           ]);
            exit;
        }
    
    // GRABAMOS...
        $user = new Usuario;
        $new = $user->create($data);
        if($new){
            $rta = [
                'status' => 0,
                'msj' => 'Usuario creado exitósamente'
            ];
        }else{
            $rta = [
                'status' => 1,
                'msj' => 'Ha ocurrido un error al grabar. Inténtelo nuevamente.'
            ];
        }
    
    
    View::renderJson($rta);

}    

/**
* Edita los datos de
* una publicación
*/  
public function editar()
{
    // DATOS RECIBIDOS
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);
        $editar = [
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'equipo' => $data['equipo'],
            'fecha_nacimiento' => $data['fecha_nacimiento'],
            'id' => $data['id'],
        ];
    // CLAVE
        $editar['clave'] =  password_hash($data['clave'], PASSWORD_DEFAULT);
    // IMAGEN
        $path = '../../frontend/img/avatares/';
        if($data['nuevaImagen'] != null){
            $imagen64 = $data['nuevaImagen'];
            list($imagenTipo, $imagenCodigo) = explode(',', $imagen64);
            // NOMBRE
                $nombreImagen = date('Ymd_His');
            // EXTENSION
                if(strpos($imagenTipo, 'image/png')) {
                    $nombreImagen .= ".png";
                } else if(strpos($imagenTipo, 'image/pjpeg') || strpos($imagenTipo, 'image/jpeg')) {
                    $nombreImagen .= ".jpg";
                } else if(strpos($imagenTipo, 'image/gif')) {
                    $nombreImagen .= ".gif";
                } else if(strpos($imagenTipo, 'image/webp')) {
                    $nombreImagen .= ".webp";
                }
            // DECODIFICAR
               $imagenDecodificada = base64_decode($imagenCodigo); 
            // CREO EL ARCHIVO
                file_put_contents($path . $nombreImagen, $imagenDecodificada);
            // DATA
            $editar['avatar'] = $nombreImagen;
        }
 
    // VALIDAR DATOS
        $validar = new Validator($data, [
            'nombre'            => ['required', 'min:3'],
            'apellido'          => ['required'],
            'email'             => ['required'],
            'clave'             => ['required', 'min:3'],
            'equipo'              => ['required'],
            'fecha_nacimiento'  => ['required'],
        ]);
        if(!$validar->passes()){
           View::renderJson([
            'status'    => 2,
            'msj'       => $validar->getErrores(),   
           ]);
            exit;
        } 
    
    // EDITAR
        $user = new Usuario();
        $edit = $user->test($editar);
    
            if($edit){
                $rta = [
                        'status' => 0,
                        'msj' => 'Publicación editada',
                    ];
            }else{
                $rta = [
                        'status' => 1,
                        'msj' => 'Ocurrió un error en la edición. Vuelva a intentarlo después.',
                    ];
            } 
        
       View::renderJson($rta); 
    
    
}    
    
    
}
<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Publicacion;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Validation\Validator;
use DaVinci\Auth\Auth;

/**
* Controlador encargado de
* las peticiones de publicaciones
*/  
class APIPublicacionesController
{
    
/**
* Devuelve la lista completa de
* publicaciones almacenadas
*/     
    public function listado()
    {         
//        if(!auth::isLogged()){
//            View::renderJson('no estas autenticado');
//        }   
        $pub  = new Publicacion;
        $pubs = $pub->getAll();
        
        $salida= [];
        foreach($pubs as $p){
            $salida[] = $p;
        }
        View::renderJson($salida);
    }

/**
* Devuelve la lista completa de
* publicaciones creadas por un usuario
*/      
    public function listadoPorUsuario()
    {
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
        
        $pub = new Publicacion;
        $rta = $pub->getAllByUser($id);
        
        View::renderJson($rta);
    }
 
/**
* Devuelve una publicación
* buscándola por su id
*/      
    public function traerPorId()
    {
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
        
        $pub = new Publicacion;
        $pub->getByPk($id);
        
        View::renderJson($pub); 
    }

/**
* Guarda un comentario nuevo
*/      
   public function grabar()
   {
       // DATOS RECIBIDOS
            $buffer = file_get_contents('php://input');
            $data = json_decode($buffer, true); 
        
       // IMAGEN
            $path = '../../frontend/img/publicaciones/';
            if($data['imagen'] != null){
                $imagen64 = $data['imagen'];
                list($imagenTipo, $imagenCodigo) = explode(',', $imagen64);
                // NOMBRE Y EXTENSION
                    $nombreImagen = date('Ymd_His');
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
                // DATA PARA GUARDAR
                    $data['imagen'] = $nombreImagen;
            }
       
       // VALIDAR
           $valid = new Validator($data, [
                'texto' => ['required', 'min:3'],
           ]);
           if(!$valid->passes()){
               echo json_encode([
                    'status' => 2,
                    'msg'    => $valid->getErrores(), 
               ]) ;
               exit;
           }
        
        // GRABAR
            $pub = new Publicacion;
            $new = $pub->create($data);
       
       // RESPUESTA
            if($new){
                $rta = [
                        'status' => 0,
                        'msg' => 'Publicación creada exitósamente.',
                        'id' => $pub->getId(),
                        'imagen' => $pub->getImagen(),
                    ];
            }else{
                $rta = [
                        'status' => 1,
                        'msg' => ['La publicación no pudo ser creada.'],
                    ];
            }
            View::renderJson($rta);
       
   }
    
/**
* Elimina una publicación 
* de la base de datos
*/      
   public function borrar()
   {
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
       
       $pub = new Publicacion;
       $del = $pub->delete($id);
       
        if($del){
            $rta = [
                    'status' => 0,
                    'msg' => 'Publicación borrada',
                ];
        }else{
            $rta = [
                    'status' => 1,
                    'msg' => 'Error al borrar.',
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
       
        // IMAGEN
            $path = '../../frontend/img/publicaciones/';
            if($data['imagen'] != null){
                $imagen64 = $data['imagen'];
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
                $data['imagen'] = $nombreImagen;
            }   
        
        // VALIDAR
            $valid = new Validator($data, [
                'texto' => ['required', 'min:3'],
                'privacidad' => ['required'],
           ]);
           if(!$valid->passes()){
               View::renderJson([
                    'status' => 2,
                    'msg'    => $valid->getErrores(), 
               ]) ;
               exit;
           }
        
        
        //EDITAR NOMAS
            $pub = new Publicacion();
            $edit = $pub->edit($data);

            if($edit){
                $rta = [
                        'status' => 0,
                        'msg' => 'Publicación editada',
                    ];
            }else{
                $rta = [
                        'status' => 1,
                        'msg' => ['Ocurrió un error y el mensaje no pudo ser editado.'],
                    ];
            } 
        
       View::renderJson($rta); 
    }
    
}
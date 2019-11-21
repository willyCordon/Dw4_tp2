<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Publicacion;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Validation\Validator;
use DaVinci\Auth\Auth;


class APIPublicacionesController
{
    
/**
* retorna el listado completo
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
 * listado completo segun el usuario
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
* retorna por id
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
      
            $buffer = file_get_contents('php://input');
            $data = json_decode($buffer, true); 
        
       
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
               
                    $imagenDecodificada = base64_decode($imagenCodigo);
                
                    file_put_contents($path . $nombreImagen, $imagenDecodificada);
                
                    $data['imagen'] = $nombreImagen;
            }
       
   
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
        
     
            $pub = new Publicacion;
            $new = $pub->create($data);
       
     
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
 * Editar publicacion
 *  */  
    public function editar()
    {
       
            $buffer = file_get_contents('php://input');
            $data = json_decode($buffer, true);
       
        
            $path = '../../frontend/img/publicaciones/';
            if($data['imagen'] != null){
                $imagen64 = $data['imagen'];
                list($imagenTipo, $imagenCodigo) = explode(',', $imagen64);
                
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
             
                   $imagenDecodificada = base64_decode($imagenCodigo); 
              
                    file_put_contents($path . $nombreImagen, $imagenDecodificada);
               
                $data['imagen'] = $nombreImagen;
            }   
        
       
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
<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Comentario;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Validation\Validator;

/**
* Clase encargada
* de las peticiones de comentarios
*/

class APIComentariosController
{

/**
*
* Busca todos los comentarios relacionados
* a una publicación por su id
*
*/    
    public function listadoPorPub()
    {
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
        
        $com = new Comentario;
        $rta = $com->comentariosPorPub($id);
        
        View::renderJson($rta);
    }
    
/**
* Guarda un comentario nuevo
*/    
    public function grabar()
    {
        // DATOS RECIBIDOS
            $buffer = file_get_contents('php://input');
            $data = json_decode($buffer, true);
        
        // VALIDO
            $valid = new Validator($data, [
                'texto' => ['required', 'min:3']
            ]);
                
            if( !$valid->passes() ){
                echo json_encode([
                    'status' => 2,
                    'msg'    => $valid->getErrores(), 
               ]) ;
               exit;           
            }
        
        // CREO EL COMENTARIO
            $comen = new Comentario;
            $nuevo = $comen->create($data);
        
        // RESPUESTA
            if($nuevo){
                $rta = [
                        'status' => 0,
                        'msg' => 'Comentario creado exitósamente.',
                        'id' => $comen->getId(),
                    ];
            }else{
                $rta = [
                        'status' => 1,
                        'msg' => ['Error al grabar.'],
                    ];
            }
        
        View::renderJson($rta); 

    }

/**
* Elimino un comentario buscándolo por su id
*/      
    public function borrar(){
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
        
        $com = new Comentario;
        $del = $com->delete($id);
        
        if($del){
            $rta = [
                    'status' => 0,
                    'msg' => 'Comentario borrado',
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
* Devulve un comentario buscado por su id
*/      
    public function traerPorId()
    {
        $parameters = Route::getUrlParameters();
        $id = $parameters['id'];
        
        $com = new Comentario;
        $com->getByPk($id);
        
        View::renderJson($com); 
    }
 
/**
* Edita la información de un comentario
*/      
    public function editar()
    {
        // DATOS RECIBIDOS
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);
       
        // VALIDO
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
        
        //EDITO NOMAS
            $com = new Comentario();
            $edit = $com->edit($data);

            if($edit){
                $rta = [
                        'status' => 0,
                        'msg' => 'Comentario editado',
                    ];
            }else{
                $rta = [
                        'status' => 1,
                        'msg' => ['El comentario no pudo ser editado'],
                    ];
            } 
        
       View::renderJson($rta); 
    }    
    
    
}
<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Comentario;
use DaVinci\Core\App;
use DaVinci\Core\Route;
use DaVinci\Validation\Validator;


class APIComentariosController
{

/**
*
* listado de comentarios relacionados
*
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
* guardar un comentario nuevo
*/    
    public function grabar()
    {
      
            $buffer = file_get_contents('php://input');
            $data = json_decode($buffer, true);
        
        
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
        
        
            $comen = new Comentario;
            $nuevo = $comen->create($data);
        
       
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
* eliminar comentario por id
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
* Trae por id
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
* Edita 
*/      
    public function editar()
    {
        
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);
       
     
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
<?php

namespace DaVinci\Controllers;

use DaVinci\Auth\Auth;
use DaVinci\Core\App;
use DaVinci\Core\View;
use DaVinci\Models\Usuario;
use DaVinci\Validation\Validator;

/**
* Controlador encargado de 
* las peticiones de autentificación
*/

class APIAuthController
{
     
    
/**
*
* Ingresa el email y clave del usuario y 
* devuelve una respuesta en base a la autentificación
*
*/    
public function doLogin(){
  
    // DATA RECIBIDA
    	$buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);    

    //TODO: VALIDAR
    // AUTH
        $auth = new Auth(new Usuario());
        $rta = $auth->login($data['email'], $data['clave']);
            
            
    View::renderJson($rta);
} 
   
/**
*
* Remueve la cookie con el token de autentificación
*/    
public function doLogout(){
    if( Auth::isLogged() ){
        $auth = new Auth(new Usuario());
        $rta = $auth->logout();
        View::renderJson('Adios');
    }
}    
    
    
}
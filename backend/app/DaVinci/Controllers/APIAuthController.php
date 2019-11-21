<?php

namespace DaVinci\Controllers;

use DaVinci\Auth\Auth;
use DaVinci\Core\App;
use DaVinci\Core\View;
use DaVinci\Models\Usuario;
use DaVinci\Validation\Validator;


class APIAuthController
{
     
    
/**
*
* Login con email y clave
*
*/    
public function doLogin(){
  
 
    	$buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);    

   // TODO: Validar :D :D :D :D :D :D
        $auth = new Auth(new Usuario());
        $rta = $auth->login($data['email'], $data['clave']);
            
            
    View::renderJson($rta);
} 
   
/**
*
* Remueve la cookie con el token 
*/    
public function doLogout(){
    if( Auth::isLogged() ){
        $auth = new Auth(new Usuario());
        $rta = $auth->logout();
        View::renderJson('Adios');
    }
}    
    
    
}
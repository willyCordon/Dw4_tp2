<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Casa;
use DaVinci\Core\App;
use DaVinci\Core\Route;

/**
* Controlador encargado de
* las peticiones de las casas
*/  
class APICasasController
{

/**
* Devuelve el listado
* completo de todas las casas
*/  
    public function listado()
    {
        $casa = new Casa;
        $rta = $casa->getAllOrder();
        
        View::renderJson($rta);
    }
    
/**
* Edita la propiedad puntos
* de una casa
*/     
    public function sumar()
    {   
       // DATOS RECIBIDOS
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);
        
        $casa = new Casa;
        $rta = $casa->sumarPuntos($data['cantidad'], $data['casa']);
        
        View::renderJson($data);
    }
    
    
}
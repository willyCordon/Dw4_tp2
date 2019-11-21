<?php

namespace DaVinci\Controllers;

use DaVinci\Core\View;
use DaVinci\Models\Equipo;
use DaVinci\Core\App;
use DaVinci\Core\Route;

/**
* Controlador encargado de
* las peticiones de las equipo
*/  
class APIEquiposController
{

/**
* Devuelve el listado
* completo de todas las equipo
*/  
    public function listado()
    {
        $equipo = new Equipo;
        $rta = $equipo->getAllOrder();
        
        View::renderJson($rta);
    }


    /**
* Devuelve el listado limitado a 3 registros
* completo de todas las equipo
*/  
public function listadoLimit()
{
    $equipo = new Equipo;
    $rta = $equipo->getLimitOrder();
    
    View::renderJson($rta);
}
    
/**
* Edita la propiedad puntos
* de una equipo
*/     
    public function sumar()
    {   
       // DATOS RECIBIDOS
        $buffer = file_get_contents('php://input');
        $data = json_decode($buffer, true);
        
        $equipo = new Equipo;
        $rta = $equipo->sumarPuntos($data['cantidad'], $data['equipo']);
        
        View::renderJson($data);
    }
    
    
}
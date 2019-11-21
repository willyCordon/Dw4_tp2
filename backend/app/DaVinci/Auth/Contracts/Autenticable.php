<?php
namespace DaVinci\Auth\Contracts;


interface Autenticable
{
    
    
/**
 * Carga los datos del usuario
 *
 * @param string $usuario
 * @return bool
 */
    public function traerPorEmail($email) : bool;

    
        
/**
 * Retorna el password.
 *
 * @return string
 */  
    public function getClave();
    
    
    
/**
 * Retorna el id.
 *
 * @return int
 */
    public function getId();
    
    
    
/**
 * Retorna el usuario.
 *
 * @return string
 */
    public function getEmail();
}
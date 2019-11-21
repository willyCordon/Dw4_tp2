<?php
namespace DaVinci\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use DaVinci\Models\Usuario;
use DaVinci\Auth\Contracts\Autenticable;

/**
* Clase encargada de manejar la autentificación de los usuarios.
*/

class Auth
{

protected $user;    

    
/**
* Instancia la clase para el usuario.
*
* @param Autenticable $user
*/
    
    public function __construct(Autenticable $user)
    {
        $this->user = $user;
    }   
    
    
/**
* Se encarga de loguear al usuario
*
* @param string $email
* @param string $clave
* @return array
*/
       
    
public function login($email, $clave){
        $API_KEY = "erifjweiofjseiofAGlasejdfja";
        if($this->user->traerPorEmail($email)){
            if(password_verify($clave, $this->user->getClave())){
                
                $builder = new Builder();
                
                $builder->setIssuer('https://davinci.edu.ar');
                $builder->setIssuedAt(time());
                $builder->set('id', $this->user->getId());
                
                $encrypter = new Sha256();
                
                $builder->sign($encrypter, $API_KEY);
                
                $token = $builder->getToken();
                setcookie('_token', (string)$token, time()+3600, "", "", false, true);
                
                //TODO OK
                    return [
                        'status' => 0,
                        'data' => [
                            'id' => $this->user->getId(),
                            'email' => $this->user->getEmail(),
                            'nombre' => $this->user->getNombre(),
                            'apellido' => $this->user->getApellido(),
                            'avatar' => $this->user->getAvatar(),
                            'equipo' => $this->user->getEquipo(),
                            'fecha_nacimiento' => $this->user->getFecha_nacimiento(),
                        ]
                    ];
                exit;
            }else{
                //NO COINCIDEN LAS CLAVES
                    return [
                        'status' => 1,
                    ];
            }
        }else{
            //NO ENCUENTRA AL USUARIO
                return [
                        'status' => 2,
                    ];;
        }
}    
    

/**
* Indica si el usuario está autenticado
*
* @return bool
*/
    
public static function isLogged()
{
    //ACA TENGO LA COOKIE ALMACENADA
        return isset($_COOKIE['_token']);               
}
    
/**
* Cierra la sesión.
*/    
    
 public function logout()
 {
     setcookie('_token', null, time() - 3600);
 }    
      
    
    
}
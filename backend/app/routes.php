<?php

use DaVinci\Core\Route;

/**
 * 
 * ************* Auntentificacion *******************
 * 
 */

/**
 * Login
 */
Route::add('POST', '/api/login', 'APIAuthController@doLogin');

/**
 * Logout
 */
Route::add('GET', '/api/logout', 'APIAuthController@doLogout');


/**
 * 
 * ************* Publicaciones *******************
 * 
 */

/**
 * Listado de publicaciones
 */
Route::add('GET', '/api/publicaciones', 'APIPublicacionesController@listado');

/**
 * Traer una publicacion
 */
Route::add('GET', '/api/publicaciones/{id}', 'APIPublicacionesController@traerPorId');

/**
 * Todas las publicaciones del usuario
 */
Route::add('GET', '/api/publicaciones/filtro/{id}', 'APIPublicacionesController@listadoPorUsuario');

/**
 * Publicaiones neuvas
 */
Route::add('POST', '/api/publicaciones', 'APIPublicacionesController@grabar');

/**
 * Borrar publicacion
 */
Route::add('DELETE', '/api/publicaciones/{id}', 'APIPublicacionesController@borrar');

/**
 * Editar publicacion
 */
Route::add('PUT', '/api/publicaciones', 'APIPublicacionesController@editar');


/**
 * 
 * ************* Uusuario *******************
 * 
 */

/**
 * Buscar usuario por id
 */
Route::add('GET', '/api/usuarios/{id}', 'APIUsuariosController@traerPorId');

/**
 * Alta de usuario
 */
Route::add('POST', '/api/usuarios', 'APIUsuariosController@grabar');

/**Edit usuario
 * 
 */
Route::add('PATCH', '/api/usuarios', 'APIUsuariosController@editar');


/**
 * 
 * ************* Comentarios *******************
 * 
 */

/**
 * Comentarios por publicacion
 */
Route::add('GET', '/api/comentarios/fil/{id}', 'APIComentariosController@listadoPorPub');

/**
 * Comentarios por id
 */
Route::add('GET', '/api/comentarios/{id}', 'APIComentariosController@traerPorId');

/**
 * Alta de comentarios
 */
Route::add('POST', '/api/comentarios', 'APIComentariosController@grabar');

/**
 * Eliminar comentarios
 */
Route::add('DELETE', '/api/comentarios/{id}', 'APIComentariosController@borrar');

/**
 * Editar publicacion
 */
Route::add('PUT', '/api/comentarios', 'APIComentariosController@editar');



/**
 * 
 * ************* Equipos *******************
 * 
 */

/**
 * Listado de equipos
 */
Route::add('GET', '/api/equipos', 'APIEquiposController@listado');

/**
 * Trae los primeros 3 equipos de la tabla
 */

Route::add('GET', '/api/equipos/limit', 'APIEquiposController@listadoLimit');

/**
 * Suma de puntos
 */
Route::add('PATCH', '/api/equipos/sumar', 'APIEquiposController@sumar');



<?php

use DaVinci\Core\Route;

/*---------------------------------------------
                AUTENTIFICACION
---------------------------------------------*/
// LOGIN
Route::add('POST', '/api/login', 'APIAuthController@doLogin');

// LOGOUT
Route::add('GET', '/api/logout', 'APIAuthController@doLogout');


/*---------------------------------------------
                PUBLICACIONES
---------------------------------------------*/
// LISTADO PUBLICACIONES
Route::add('GET', '/api/publicaciones', 'APIPublicacionesController@listado');

// TRAER UNA PUBLICACION
Route::add('GET', '/api/publicaciones/{id}', 'APIPublicacionesController@traerPorId');

// BUSCAR TODAS LAS PUBLICACIONES DE UN USUARIO
Route::add('GET', '/api/publicaciones/filtro/{id}', 'APIPublicacionesController@listadoPorUsuario');

// GUARDAR PUBLICACION NUEVA
Route::add('POST', '/api/publicaciones', 'APIPublicacionesController@grabar');

// BORRAR PUBLICACION
Route::add('DELETE', '/api/publicaciones/{id}', 'APIPublicacionesController@borrar');

// EDITAR PUBLICACION
Route::add('PUT', '/api/publicaciones', 'APIPublicacionesController@editar');


/*---------------------------------------------
                USUARIO
---------------------------------------------*/
// BUSCAR UN USUARIO POR ID
Route::add('GET', '/api/usuarios/{id}', 'APIUsuariosController@traerPorId');

// ALTA DE USUARIO
Route::add('POST', '/api/usuarios', 'APIUsuariosController@grabar');

// MODIFICAR USUARIO
Route::add('PATCH', '/api/usuarios', 'APIUsuariosController@editar');


/*---------------------------------------------
                COMENTARIOS
---------------------------------------------*/
// BUSCAR TODOS LOS COMENTARIOS BUSCANDOLOS POR PUBLICACION
Route::add('GET', '/api/comentarios/fil/{id}', 'APIComentariosController@listadoPorPub');

// BUSCAR UN COMENTARIO POR ID
Route::add('GET', '/api/comentarios/{id}', 'APIComentariosController@traerPorId');

// ALTA DE COMENTARIOS
Route::add('POST', '/api/comentarios', 'APIComentariosController@grabar');

// BAJA DE COMENTARIOS
Route::add('DELETE', '/api/comentarios/{id}', 'APIComentariosController@borrar');

// EDITAR PUBLICACION
Route::add('PUT', '/api/comentarios', 'APIComentariosController@editar');



/*---------------------------------------------
                        Equipos
---------------------------------------------*/
// LISTADO DE Equipos
Route::add('GET', '/api/equipos', 'APIEquiposController@listado');

//Listado de equipos limitado a 3

Route::add('GET', '/api/equipos/limit', 'APIEquiposController@listadoLimit');

// SUMADO DE PUNTOS
Route::add('PATCH', '/api/equipos/sumar', 'APIEquiposController@sumar');



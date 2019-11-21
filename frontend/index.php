<!DOCTYPE html>
<html>
<head>
    <title>Parcial 2 - Programacion III y Clientes Web Mobile</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://fonts.googleapis.com/css?family=Average&display=swap" rel="stylesheet"> 
    <script src="js/main.js"></script>
</head>
<body>
<div id='app'>



<header id='top'>

<nav id='navegar' class='nav'>
	<div class='container-fluid'>
	
		<div class='navbar-header'>
			<h1 class='navbar-brand'>Sobre Futbol</h1>
			<button id='btn-navbar' class='navbar-toggle collapsed'data-toggle='collapse' data-target='#navbar'>
				<span class='glyphicon glyphicon-th'></span>
			</button>
		</div>
		
		<div class='collapse navbar-collapse' id='navbar'>
			<ul v-if='auth.valid == true' class='nav navbar-nav navbar-right'>
                <li><router-link to="/">Inicio</router-link></li>    
                <li><router-link to="/perfil">Mi Perfil</router-link></li>    
                <li><router-link to="/posiciones">Posiciones</router-link></li>    
                <li><router-link to="/logout">Cerrar sesión</router-link></li> 
			</ul>
		</div>
		
	</div>

	</nav>

</header>

<main>
    <div class='container'>
        <router-view></router-view>
    </div>
</main>
   
   
<footer id='bottom'>
    <h1>Sobre Futbol</h1>
    <p>Diseño y Programación: Willy Cordon & Alejadro Didonato</p>
    <p>Clientes web mobile & Programacino III</p>
</footer>
    
    </div>
    <script src='js/vue.js'></script>
    <script src="js/vue-router.js"></script>
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/bootstrap.js"></script>
    
    
    <script src='js/componentes/login-page.js'></script>
    <script src='js/componentes/login-page-form.js'></script>
    <script src='js/componentes/logout-page.js'></script>
    <script src='js/componentes/registro-form.js'></script>
        
    <script src='js/componentes/muro-page.js'></script>
    <script src='js/componentes/muro-page-listado.js'></script>
    <script src='js/componentes/muro-page-casas.js'></script>
    <script src='js/componentes/muro-page-casas-fila.js'></script>

    <script src='js/componentes/perfil-page.js'></script>
    <script src='js/componentes/perfil-editar.js'></script>
    
    <script src='js/componentes/publicacion-page.js'></script>
    <script src='js/componentes/publicacion-page-comentarios.js'></script>
    
    <script src='js/componentes/publicaciones-alta.js'></script>
    <script src='js/componentes/publicaciones-editar.js'></script>
    
    <script src='js/componentes/comentarios-alta.js'></script>
    <script src='js/componentes/comentarios-editar.js'></script>
    
    
    <script src='js/componentes/publicaciones-simples.js'></script>

    <script src='js/componentes/tabla-posiciones.js'></script>
    <script src='js/componentes/tabla-posiciones-fila.js'></script>
    
    <script src="js/app.js"></script>
    

</body>
</html>
    
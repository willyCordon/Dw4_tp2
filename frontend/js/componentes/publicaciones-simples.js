Vue.component('publicaciones-simples',{
    template: `<div>  
    <article :class="'pub ' + estilo ">

        <div class='pub-user'>
            <router-link :to='urlPerfilUsuario'>
            <figure class='pub-img'>
                <img :alt="'Avatar de ' + usuario.apellido + ' ' + usuario.nombre" :src="'img/avatares/' + usuario.avatar" class='img-circle'/>
                <figcaption>
                   <h3>{{usuario.nombre}} {{usuario.apellido}} <small>- equipo de {{equipo}}</small></h3>
                    <div class='pub-date'>
                        <span><i class='pub-icon glyphicon glyphicon-calendar'></i>{{publicacion.dia}}</span> 
                        <span><i class='pub-icon glyphicon glyphicon-time'></i>{{publicacion.hora}}</span>
                        <span v-if='publicacion.usuario == auth.id'> - Privacidad: {{publicacion.privacidad}}</span>
                    </div>
                </figcaption>
            </figure>
            </router-link>

            <div v-if='publicacion.usuario == auth.id' class="dropdown">
              <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class='glyphicon glyphicon-option-vertical'></i>
              </span>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><router-link :to='urlEditarPub'>Editar</router-link></li>
                <li @click='borrarPub'>Borrar</li>
              </ul>
            </div>


        </div>

<div class='pub-cont'>
<p>{{publicacion.texto}}</p>
<figure v-if='publicacion.imagen != null' class='img-pub'>
    <img class='img-responsive ' :alt='altPub' :src='rutaImagen'>
</figure>
</div>

<div class='pub-btn'>
    <router-link class='btn ' :to='urlVerPub'>Comentar</router-link>
</div>

    </article>
</div>`,
    props:['publicacion'],
    data: function(){
        return{
            usuario: {
                nombre: "",
                apellido: "",
                equipo: "",
                email: "",
                id: "",
                avatar: "",
            },
            equipo:'',
        }
    },
    computed: {
        auth: function(){
            return store.auth;
        },
        urlPerfilUsuario: function() {
            return '/perfil/' + this.usuario.id;
        },
        urlVerPub: function(){
            return '/publicaciones/' + this.publicacion.id + '/ver';
        },
        urlEditarPub: function(){
            return '/publicaciones/' + this.publicacion.id + '/editar';
        },
        estilo: function(){
            let equipo = parseInt(this.usuario.equipo)
            switch(equipo){
                case 1: this.equipo =  'Aldosivi'             ;return 'ald';break; 
                    case 2: this.equipo =  'Argentinos'           ;return 'arg';break; 
                    case 3: this.equipo =  'Arsenal'              ;return 'ars';break; 
                    case 4: this.equipo =  'Atlético Tucumán'     ;return 'atl';break; 
                    case 5: this.equipo =  'Banfield'             ;return 'banf';break; 
                    case 6: this.equipo =  'Boca Juniors'         ;return 'Cabj';break; 
                    case 7: this.equipo =  'Central Córdoba'      ;return 'cen';break; 
                    case 8: this.equipo =  'Colón'                ;return 'col';break; 
                    case 9: this.equipo =  'Defensa y Justicia'   ;return 'def';break; 
                    case 10: this.equipo = 'Estudiantes'          ;return 'est';break; 
                    case 11: this.equipo = 'Gimnasia y Esgrima'   ;return 'gimn';break; 
                    case 12: this.equipo = 'Godoy Cruz'           ;return 'godoy';break; 
                    case 13: this.equipo = 'Huracán'              ;return 'hur';break; 
                    case 14: this.equipo = 'Independiente'        ;return 'ind';break; 
                    case 15: this.equipo = 'Lanús'                ;return 'ln';break; 
                    case 16: this.equipo = 'Newells Old Boys'     ;return 'nob';break; 
                    case 17: this.equipo = 'Patronato'            ;return 'patr';break; 
                    case 18: this.equipo = 'Racing'               ;return 'rac';break; 
                    case 19: this.equipo = 'River Plate (ARG)'    ;return 'rv';break; 
                    case 20: this.equipo = 'Rosario Central'      ;return 'ros';break; 
                    case 21: this.equipo = 'San Lorenzo'          ;return 'sl';break; 
                    case 22: this.equipo = 'Talleres'             ;return 'tall';break; 
                    case 23: this.equipo = 'Unión de Santa Fe'    ;return 'usf';break; 
                    case 24: this.equipo = 'Vélez Sarsfield'      ;return 'vs';break;
 
            }
        },
        altPub: function(){
            return this.usuario.nombre + " " + new Date().getTime();
        },
        rutaImagen: function(){
            return 'img/publicaciones/' + this.publicacion.imagen;
        }
    },
    

 
 


    mounted: function(){
/**
* Pregunta si el perfil es
* o no el usuario logueado
*
* De no serlo hace la petición
* para traer los datos del usuario
*/
        if(this.publicacion.usuario == this.auth.id){
            this.usuario.id = this.auth.id;
            this.usuario.nombre = this.auth.nombre;
            this.usuario.apellido = this.auth.apellido;
            this.usuario.email = this.auth.email;
            this.usuario.avatar = this.auth.avatar;
                        if(this.usuario.avatar == null){
                            this.usuario.avatar = "default.jpg";
                        }            
            this.usuario.equipo = this.auth.equipo;
        }else{
             fetch('../backend/public/api/usuarios/' + this.publicacion.usuario, {
                credentials: 'include'
            })
            .then(rta => rta.json())
            .then(user => {
                this.usuario.nombre = user.nombre;
                this.usuario.apellido = user.apellido;
                this.usuario.id = user.id;
                this.usuario.avatar = user.avatar;
                     if(this.usuario.avatar == null){
                        this.usuario.avatar = "default.jpg";
                    }                
                this.usuario.equipo = user.equipo;
                this.usuario.email = user.email;
            }); 
        }
    },
    methods:{
/**
* Envía la petición para borrar
* la publicación
*/        
            borrarPub: function(){
                let conf = confirm('¿Está seguro que desea borrar ésta publicación?');
                if(conf){
                    fetch('../backend/public/api/publicaciones/' + this.publicacion.id, {
                        method:'DELETE',
                        credentials: 'include'
                    })
                        .then(rta => rta.json())
                        .then(data => {
                            if(data.status == 0){
                                this.$emit('deleted', this.publicacion);
                            }    
                        })
                }
            }
        }    
});
Vue.component('perfil-page',{
    template: `<div>  
        <div class='row'>
            <div class='col-xs-12 col-sm-6 col-sm-offset-3 col-md-offset-0 col-md-3'>
                <div :class="'row perfil-user ' + equipo.clase" >
                        <img  
                            :alt="auth.apellido  + ' ' + auth.nombre" 
                            :src="rutaImagen" 
                            class='img-responsive text-center img-circle img-perfil' 
                        />
                        <h2 class='text-center'>{{usuario.nombre}} {{usuario.apellido}}</h2>
                        <div><router-link to='perfil/editar'>Editar perfil</router-link></div>
                        <ul class='datos-perfil'>
                            <li>{{usuario.email}}</li>
                            <li>{{usuario.fecha_nacimiento}}</li>
                            <li :class="equipo.clase">equipo de {{equipo.nombre}}</li>
                        </ul>
                </div>
            </div>
            <div class='col-xs-12 col-md-8'>
                <div :class="status.clase" v-if="status.msj != ''"><p>{{status.msj}}</p></div>
                <publicaciones-alta @creado="agregarPub" v-if='usuario.id == auth.id'>
                </publicaciones-alta>
                <h2>Listado de publicaciones</h2>
                <publicaciones-simples
                    v-for='publicacion in publicaciones'
                    v-if="publicacion.privacidad == 'Todos' || publicacion.usuario == auth.id"
                    :key='publicacion.id'
                    :publicacion = "publicacion"
                    @deleted= 'borrarPub'
                >        
                </publicaciones-simples>
                <div class='sinComentarios' v-if='publicaciones.length == 0'>
                    <p>Por el momento este usuario no ha publicado nada en su muro.</p>
                </div>
            </div>
        </div>
</div>`,
    computed: {
        auth: function() {
            return store.auth;
        },
        rutaImagen: function(){
            return "img/avatares/" + this.usuario.avatar;
        },
        equipos: function(){
            return store.equipos;    
        },  
    },
    data: function(){
        return {
            usuario: {
                nombre: '',
                apellido: '',
                id: '',
                email: '',
                equipo: '',
                avatar: '',
            },
            publicaciones: [],
            status:{
                msj : '',
                clase : ''
            },
            equipo: {
                nombre: '',
                clase: '',
            }
        }
    },
    methods: {
/**
* Elimina de la lista en pantalla
* la publicación que fue removida
* de la base de datos
*/        
        borrarPub: function(publi){
            this.publicaciones = this.publicaciones.filter(pub => pub.id !== publi.id)
        },
/**
* Agrega a la lista en pantalla
* la publicación que fue creada
*/        
        agregarPub:function(nuevo){
            this.publicaciones.unshift(nuevo);
        },
/**
* Devuelve los datos de la equipo del usuario
*/        
        seleccionarequipo: function(num){
            num = parseInt(num);
            switch(num){
           
                case 1: this.equipo.clase  = ' ald'  , this.equipo.nombre =    'Aldosivi'           ; break;     
                case 2: this.equipo.clase  = ' arg'  , this.equipo.nombre =    'Argentinos'         ; break; 
                case 3: this.equipo.clase  = ' ars'  , this.equipo.nombre =    'Arsenal'            ; break; 
                case 4: this.equipo.clase  = ' atl'  , this.equipo.nombre =    'Atlético Tucumán'   ; break; 
                case 5: this.equipo.clase  = ' banf' , this.equipo.nombre =    'Banfield'           ; break; 
                case 6: this.equipo.clase  = ' Cabj' , this.equipo.nombre =    'Boca Juniors'       ; break; 
                case 7: this.equipo.clase  = ' cen'  , this.equipo.nombre =    'Central Córdoba'    ; break; 
                case 8: this.equipo.clase  = ' col'  , this.equipo.nombre =    'Colón'              ; break; 
                case 9: this.equipo.clase  = ' def'  , this.equipo.nombre =    'Defensa y Justicia' ; break; 
                case 10: this.equipo.clase = ' est'  , this.equipo.nombre =    'Estudiantes'        ; break; 
                case 11: this.equipo.clase = ' gimn' , this.equipo.nombre =    'Gimnasia y Esgrima' ; break; 
                case 12: this.equipo.clase = ' godoy', this.equipo.nombre =    'Godoy Cruz'         ; break; 
                case 13: this.equipo.clase = ' hur'  , this.equipo.nombre =    'Huracán'            ; break; 
                case 14: this.equipo.clase = ' ind'  , this.equipo.nombre =    'Independiente'      ; break; 
                case 15: this.equipo.clase = ' ln'   , this.equipo.nombre =    'Lanús'              ; break; 
                case 16: this.equipo.clase = ' nob'  , this.equipo.nombre =    'Newells Old Boys'   ; break; 
                case 17: this.equipo.clase = ' patr' , this.equipo.nombre =    'Patronato'          ; break; 
                case 18: this.equipo.clase = ' rac'  , this.equipo.nombre =    'Racing'             ; break; 
                case 19: this.equipo.clase = ' rv'   , this.equipo.nombre =    'River Plate (ARG)'  ; break; 
                case 20: this.equipo.clase = ' ros'  , this.equipo.nombre =    'Rosario Central'    ; break; 
                case 21: this.equipo.clase = ' sl'   , this.equipo.nombre =    'San Lorenzo'        ; break; 
                case 22: this.equipo.clase = ' tall' , this.equipo.nombre =    'Talleres'           ; break; 
                case 23: this.equipo.clase = ' usf'  , this.equipo.nombre =    'Unión de Santa Fe'  ; break; 
                case 24: this.equipo.clase = ' vs'   , this.equipo.nombre =    'Vélez Sarsfield' ; break;


   

            }
        }        
    },    
    mounted: function(){ 

           
    // BUSCO LOS DATOS DEL USUARIO SEGUN SI HAY O NO PARAM
        let idUser = "";
        if(!this.$route.params.id){
            this.usuario.nombre = this.auth.nombre;
            this.usuario.apellido = this.auth.apellido;
            this.usuario.id = this.auth.id;
            this.usuario.equipo = this.auth.equipo;
            this.seleccionarequipo(this.auth.equipo)
            this.usuario.email = this.auth.email;
            this.usuario.fecha_nacimiento = this.auth.fecha_nacimiento;
            idUser = this.auth.id;
            this.usuario.avatar = this.auth.avatar;
            if(this.usuario.avatar == null){
                this.usuario.avatar = "default.jpg";
            }            
        }else{
            idUser = this.$route.params.id;
            fetch('../backend/public/api/usuarios/' + this.$route.params.id, {
                credentials: 'include'
            })
                .then(rta => rta.json())
                .then(user => {
                    this.usuario.nombre = user.nombre;
                    this.usuario.apellido = user.apellido;
                    this.usuario.email = user.email;
                    this.usuario.id = user.id;
                    this.usuario.avatar = user.avatar;
                        if(this.usuario.avatar == null){
                            this.usuario.avatar = "default.jpg";
                        }
                    this.usuario.equipo = user.equipo
                    this.seleccionarequipo(user.equipo);
                    this.usuario.fecha_nacimiento = user.fecha_nacimiento;
                });             
            
        }
    // BUSCO LA LISTA DE PUBLICACIONES
        fetch('../backend/public/api/publicaciones/filtro/' + idUser, {
                credentials: 'include'
            })
                .then(rta => rta.json())
                .then(publis => {
                    this.publicaciones = publis;
                    this.publicaciones.reverse();
                })
    // MENSAJE
        if(this.$route.params.msj){
            switch(this.$route.params.msj){
                case 'editado': 
                    this.status.msj = "Su publicación ha sido editada satisfactoriamente.";
                    this.status.clase = "msj-ok";
                    break;
                case 'borrado': 
                    this.status.msj = "Su publicación ha sido borrada satisfactoriamente.";
                    this.status.clase = "msj-ok";
                    break;
                case 'usereditado':
                    this.status.msj = "Sus datos han sido modificados sin problema.";
                    this.status.clase = "msj-ok";
                    break;                    
            }
            
        }
        
for(let i = 0; i < this.equipos.length; i++)
    console.log(this.equipos[i])
    },
});
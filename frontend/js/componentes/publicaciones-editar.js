Vue.component('publicaciones-editar',{
    template: `<div><div class='row'><div class='col-xs-12 col-md-8 col-md-offset-2'>
        <article id='editar' :class="'pub ' + estilo ">
            <header class='pub-user'>
                <figure class='pub-img'>
                    <img :src="'img/avatares/' + usuario.avatar" alt='cosme' class='img-circle'>
                    <figcaption>
                        <h3>{{usuario.nombre}} {{usuario.apellido}}</h3>
                        <div class='pub-date'>
                        <span><i class='pub-icon glyphicon glyphicon-calendar'></i>{{publicacion.dia}}</span> 
                        <span><i class='pub-icon glyphicon glyphicon-time'></i>{{publicacion.hora}}</span>
                    </div>
                    </figcaption>
                </figure>
            </header>
            <div class='pub-cont'>
                <form class='form' @submit.prevent='grabar'>
                    <label for='publi'>Editar publicacion</label>
                    <input type='text' name='publicar' id='publi' v-model='publicacion.texto' class='form-control' placeholder='¿Qué estás haciendo?'/>

                    <figure v-if='publicacion.imagen != null && nuevaImagen == null' class='img-pub'>
                        <img class='img-responsive' :alt='altPub' :src='rutaImagen'>
                        <i @click='sinImagen' class='glyphicon glyphicon-remove sinImagen'></i>
                    </figure>
                    
                    <figure v-if='nuevaImagen != null' class='img-pub'>
                        <img class='img-responsive' alt='Previsualización' :src='nuevaImagen'>
                        <i @click='sinImagen' class='glyphicon glyphicon-remove sinImagen'></i>
                    </figure>

                    <div class='pub-btn'>
                    <select v-model='publicacion.privacidad'>
                                <option value='Todos'>Todos</option>
                                <option value='Sólo equipo'>Sólo equipo</option>
                                <option value='Sólo yo'>Sólo yo</option>
                            </select>
                    <div class='imagenUpload'>
                                <input  type='file'
                                        @change='leerImagen'
                                />
                    </div>
                        <button id='publicar-btn' class='btn btn-primary btnedit'>Editar</button>
                    </div>
                </form>
                <ul class='error-alta' v-if='status != ""'>
                        <li v-for='msj in status'>{{msj}}</li>
                    </ul>
            </div>
        </article></div></div>
</div>`,
    data: function(){
        return{
            publicacion:{
                id: '',
                texto: '',
                privacidad: '',
                dia: '',
                hora: '',
                usuario: '',
                imagen: '',
            },
            usuario: {
                    id: '',                    
                    email: '',                    
                    equipo: '',                    
                    nombre: '',                    
                    apellido: '',                    
                    avatar: '',                    
            },
            status: '',
            equipo: '',
            nuevaImagen : null,
        } 
    },
    mounted: function(){
        // TRAIGO LA PUBLICACION
            fetch('../backend/public/api/publicaciones/' + this.$route.params.id , {
                credentials: 'include'
            })
            .then(rta => rta.json())
            .then(pub => {
                this.publicacion.id = pub.id;
                this.publicacion.texto = pub.texto;
                this.publicacion.privacidad = pub.privacidad;
                this.publicacion.dia = pub.dia;
                this.publicacion.hora = pub.hora;
                this.publicacion.usuario = pub.usuario;
                this.publicacion.imagen = pub.imagen;
            // TRAIGO USUARIO
                fetch('../backend/public/api/usuarios/' + pub.usuario , {
                        credentials: 'include'
                    })
                    .then(rta => rta.json())
                    .then(user => {
                        this.usuario.nombre = user.nombre;
                        this.usuario.apellido = user.apellido;
                        this.usuario.email = user.email;
                        this.usuario.equipo = user.equipo;
                        this.usuario.id = user.id;
                        this.usuario.avatar = user.avatar;
                                            if(this.usuario.avatar == null){
                            this.usuario.avatar = "default.jpg";
                        }
                    }) 
            })    
    },
    methods: {
/**
* Envía la petición
* para editar todos los
* datos de la publicación
*/        
        grabar: function(){
            fetch('../backend/public/api/publicaciones', {
                method:'PUT',
                body: JSON.stringify(this.publicacion),
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(rta => rta.json())
            .then(data => {
                if(data.status == 2){
                    this.status = data.msg.texto;
                }else if(data.status == 1){
                    this.status = data.msg;
                }else if(data.status == 0){
                    this.status = "";
                    this.$router.push('/perfil/' + this.auth.id + "/editado" );
                }
            })
        },
/**
* Se encarga de leer la
* imagen ingresada en el formulario
*/        
        leerImagen: function(ev){
            const imgUpload = ev.target.files[0];
            const reader = new FileReader();
            const self = this;
            reader.addEventListener('load', function(){
                self.nuevaImagen = reader.result
                self.publicacion.imagen = reader.result
            })
            reader.readAsDataURL(imgUpload);
        },
/**
* Vacía los datos de la imagen
* en caso de no haber ninguna ingresada
*/        
        sinImagen: function(){
            this.nuevaImagen = null;
            this.publicacion.imagen = null;
        }
    },
    computed: {
        auth: function(){
            return store.auth;
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
});
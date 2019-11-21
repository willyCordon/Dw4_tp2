Vue.component('publicacion-page-comentarios',{
    template: `<div>  
                    <div :class="'row comentario ' + estilo">
                        <div class='col-xs-12'>
                            <div v-if='usuario.id == auth.id' class="dropdown">
                              <span type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class='glyphicon glyphicon-option-vertical'></i>
                              </span>
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><router-link :to='urlEditarComentario'>Editar</router-link></li>
                                <li @click='borrarComentario'><a href='#'>Borrar</a></li>
                              </ul>
                            </div>
                            <div class='col-xs-8 col-xs-offset-2 col-sm-offset-0 col-sm-2 cont-img'>
                                <img :alt="'Avatar de ' + usuario.apellido + ' ' + usuario.nombre" :src="'img/avatares/' + usuario.avatar" class='img-circle img-responsive' />
                                <img alt='escudo' :src="'img/escudos/'+ estilo + '.png'" class='escudito' />
                            </div>
                            <div class='col-xs-12 col-sm-10'>
                                <router-link :to='urlPerfilUsuario'>
                                    <h3>{{usuario.nombre}} {{usuario.apellido}} <small>- equipo de {{equipo}}</small></h3>
                                    <div class='pub-date'>
                                        <span><i class='pub-icon glyphicon glyphicon-calendar'></i>{{comentario.dia}}</span> 
                                        <span><i class='pub-icon glyphicon glyphicon-time'></i>{{comentario.hora}}</span>
                                    </div>
                                </router-link>
                                <p class='comentario-txt'>{{comentario.texto}}</p>
                            </div>
                        </div>
                    </div>
</div>`,
    props:['comentario'],
    computed:{
      auth: function(){
        return store.auth;
      },
      urlEditarComentario: function(){
        return "/comentarios/" + this.comentario.id + "/editar";
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
        urlPerfilUsuario: function() {
            return '/perfil/' + this.usuario.id;
        },        
    },
    
    data: function(){
        return{
            usuario: {
                id:'', 
                nombre:'', 
                apellido:'', 
                email:'', 
                equipo:'', 
                avatar:'', 
            },
            equipo: ''
        }
    },
    mounted:function(){
        // TRAER AL USUARIO
            fetch('../backend/public/api/usuarios/' + this.comentario.usuario, {
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
                        this.usuario.equipo = user.equipo;
                    }); 
    },
    methods: {
/**
* Envía la petición para
* eliminar el comentario 
*/        
        borrarComentario(){
            let rta = confirm( '¿Está seguro que desea borrar este comentario?');
            
            if(rta){
                fetch('../backend/public/api/comentarios/' + this.comentario.id, {
                      credentials: 'include',
                      method: 'DELETE'
                      })
                .then(rta => rta.json())
                .then(data => {
                    if(data.status == 0){
                        this.$emit('deleted', this.comentario);
                    }
                })
            }
        }//FIN DE BORRAR COMENTARIO
    }
});
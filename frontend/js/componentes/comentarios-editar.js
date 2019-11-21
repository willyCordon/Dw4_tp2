Vue.component('comentarios-editar',{
    template: `<div>  
<div class='row'>
<div class='col-xs-12 col-sm-8 col-sm-offset-2'>
        <article id='editar' :class="'pub ' + estilo ">
            <div class='pub-user'>
                <figure class='pub-img'>
                    <img :src="'img/avatares/' + auth.avatar" alt='cosme' class='img-circle'>
                    <figcaption>
                        <h3>{{auth.nombre}} {{auth.apellido}}</h3>
                        <div class='pub-date'>
                        <span><i class='pub-icon glyphicon glyphicon-calendar'></i>{{comentario.dia}}</span> 
                        <span><i class='pub-icon glyphicon glyphicon-time'></i>{{comentario.hora}}</span>
                    </div>
                    </figcaption>
                </figure>
            </div>
            <div class='pub-cont'>
                <form class='form' @submit.prevent='grabar'>
                    <label for='publi'>Editar comentario</label>
                    <input type='text' name='publicar' id='publi' v-model='comentario.texto' class='form-control' placeholder='¿Qué estás haciendo?'/>

                            <button id='publicar-btn' class='btn btn-primary'>Editar</button>
                </form>
                <ul class='error-alta' v-if='status != ""'>
                        <li v-for='msj in status'>{{msj}}</li>
                    </ul>
            </div>
        </article>
</div>
</div>
        </div>`,
    computed:{
        auth:function(){
            return store.auth;
        },
        estilo: function(){
                let equipo = parseInt(this.auth.equipo)
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
    },
    data:function(){
        return{
            comentario: {
                id: '',
                dia: '',
                hora: '',
                publicacion: '',
                usuario: '',
                texto: '',
            },
            status: '',
            equipo:'',
        }
    },
    mounted:function(){
        //BUSCO EL COMENTARIO
            fetch('../backend/public/api/comentarios/' + this.$route.params.id , {
                credentials: 'include'
            })
            .then(rta => rta.json())
            .then(com => {
                this.comentario.id = com.id;
                this.comentario.dia = com.dia;
                this.comentario.hora = com.hora;
                this.comentario.publicacion = com.publicacion;
                this.comentario.usuario = com.usuario;
                this.comentario.texto = com.texto;
            })
            if(this.auth.avatar == null){
                this.auth.avatar = "default.jpg";
            }
    },
    methods: {
/**
*
* Envía la petición para
* la ediciónd e los datos
* de un comentario
*
*/        
        grabar: function(){
            fetch('../backend/public/api/comentarios', {
                method:'PUT',
                body: JSON.stringify(this.comentario),
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
                    this.$router.push('/publicaciones/' + this.comentario.publicacion + "/ver" );
                }
            })
        }
    },    
});
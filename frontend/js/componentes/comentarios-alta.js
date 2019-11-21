Vue.component('comentarios-alta',{
    template: `<div>  
                    <div class='publicar'>
                        <form class='form' @submit.prevent="grabar">
                            <label for='publi'>Publicar comentario</label>
                            <input type='text' name='publicar' id='publi' v-model='comentario.texto' class='form-control' placeholder='¿Qué opinas de esto?'/>
                            <button id='publicar-btn' class='btn btn-primary'>Publicar</button>
                        </form>
                    <ul class='error-alta' v-if='status.mensaje != ""'>
                        <li v-for='msj in status.mensaje'>{{msj}}</li>
                    </ul>
                    </div>
</div>`,
    data: function(){
        return{
            comentario:{
                texto: '',
                dia: '',
                hora: '',
                publicacion: '',
                usuario: '',
            },
            status:{
                mensaje: '',
            }
        }
    },
    computed:{
        auth:function(){
            return store.auth;
        }
    },
    methods:{
/**
* Función que retorna la fecha actual
* en el formato necesario para 
* la base de datos
*
* @return string
*/        
        dameFecha : function(){
            let año = new Date().getFullYear();
            let mes = new Date().getMonth() + 1;
            if(mes < 10){
                mes = '0' + mes;
            }
            let dia = new Date().getDate();
            return año + "-" + mes + "-" + dia;
        },
/**
* Función que retorna la hora actual
* en el formato necesario para 
* la base de datos
*
* @return string
*/        
        dameHora: function(){
            let hora = new Date().getHours();  
            let minutos = new Date().getMinutes();
            if(minutos < 10){
                minutos = '0' + minutos;
            }            
            let segundos = new Date().getSeconds();
            if(segundos < 10){
                segundos = '0' + segundos;
            }  
            return hora + ':' + minutos + ":" + segundos;
        },
/**
* Envía la petición
* para guardar un nuevo
* comentario
*/        
        grabar: function(){
            // DATOS RESTANTES
                this.comentario.dia = this.dameFecha();
                this.comentario.hora = this.dameHora();
                this.comentario.usuario = this.auth.id;
                this.comentario.publicacion = this.$route.params.id;
            // FETCH
                fetch('../backend/public/api/comentarios', {
                    method: 'POST',
                    body: JSON.stringify(this.comentario),
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    }                    
                })
                .then(rta => rta.json())
                .then(data => {
                    if(data.status == 2){
                        this.status.mensaje = data.msg.texto;
                    }else if(data.status == 1){
                        this.status.mensaje = data.msg;
                    }else if(data.status == 0){
                        this.status.mensaje = "";
                        let nuevo = {
                            id: data.id,
                            texto: this.comentario.texto,
                            dia: this.comentario.dia,
                            hora: this.comentario.hora,
                            usuario: this.comentario.usuario,
                            publicacion: this.comentario.publicacion,
                        };
                        this.$emit('creado', nuevo);
                        this.comentario.texto = '';
                    }
                })            
        }//FIN DE GRABAR
    }
});
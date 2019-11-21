Vue.component('publicaciones-alta',{
    template: `<div>  
                    <div class='publicar'>
                        <form class='form' @submit.prevent="grabar">
                            <label for='publi'>Publicar comentario</label>

                            <input type='text' name='publicar' id='publi' v-model='pubNueva.texto' class='form-control' placeholder='¿Qué estás haciendo?'/>

                            <select v-model='pubNueva.privacidad'>
                                <option value='Todos'>Todos</option>
                                <option value='Sólo yo'>Sólo yo</option>
                            </select>

                            <div class='imagenUpload'>
                                <input  type='file'
                                        @change='leerImagen'
                                />
                            </div>

                            <button id='publicar-btn' class='btn btn-primary'>Publicar</button>
                        </form>
                    <ul class='error-alta' v-if='error != ""'>
                        <li v-for='msj in error'>{{msj}}</li>
                    </ul>
                    </div>
</div>`,
    data: function(){
        return{
            pubNueva: {
                texto: null,
                hora: null,
                dia: null,
                usuario: null,
                privacidad: 'Todos',
                imagen: null,
            },
            error: "",
        }
    },
    methods: {
/**
* Lee los datos de la
* imagen ingresada en
* el formulario
*/        
        leerImagen: function(ev){
            const imgUpload = ev.target.files[0];
            const reader = new FileReader();
            const self = this;
            reader.addEventListener('load', function(){
                self.pubNueva.imagen = reader.result
            })
            reader.readAsDataURL(imgUpload);
        },
/**
* Devuelve la fecha actual
* en el formato necesario
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
* Devuelve la hora actual
* en el formato necesario
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
* Realiza la petición para almacenar
* los datos de la publicación ingresada
*
*/         
        grabar : function(){
            // TODO DATOS
                this.pubNueva.usuario = this.auth.id;
                this.pubNueva.dia = this.dameFecha()
                this.pubNueva.hora = this.dameHora();

            fetch('../backend/public/api/publicaciones', {
                method: 'POST',
                body: JSON.stringify(this.pubNueva),
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(rta => rta.json())
            .then(data => {
                if(data.status == 2){
                    this.error = data.msg.texto;
                }else if(data.status == 1){
                    this.error = data.msg;
                }else if(data.status == 0){
                    let nuevo = {
                        id: data.id,
                        texto: this.pubNueva.texto,
                        usuario: this.pubNueva.usuario,
                        dia: this.pubNueva.dia,
                        hora: this.pubNueva.hora,
                        privacidad: this.pubNueva.privacidad,
                        imagen: data.imagen,
                    };
                    this.$emit('creado', nuevo);
                    this.pubNueva.texto = '';
                    this.error = "";
                    this.sumarPunto(5);
                }
            })
        },
/**
* Realiza la petición para sumar
* los puntos obtenidos a los 
* puntajes de su equipo
*/        
        sumarPunto: function(num){
            let data = {
                equipo : this.auth.equipo,
                cantidad : num
            }
            fetch('../backend/public/api/equipos/sumar', {
                method:'PATCH',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(rta => rta.json())
            .then(data => {
                console.log("5 PUNTOS!")
                store.equipos[this.auth.equipo].puntos = parseInt(store.equipos[this.auth.equipo].puntos) + 5;               
            })
        }
    },    
    computed:{
        auth: function(){
            return store.auth;
        },
        equipos: function(){
           return store.equipos; 
        },
        equipo: function(){
            return this.equipos[this.auth.equipo];
        }
    },
});
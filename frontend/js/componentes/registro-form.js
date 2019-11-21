Vue.component('registro-form',{
    template: `<div>
        <h2 class='text-center titleRegister'>Registrar usuario</h2>
        <div class='form-registro'>
            <div :class="aviso.class"><p>{{aviso.msj}}</p></div>
            <form @submit.prevent='grabar'>
            <div class='row'>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='nombre'>Nombre</label>
                    <input type='text' id='nombre' name='nombre' class='form-control' v-model='usuario.nombre' />
                    <ul class='list-error' v-if='aviso.error.nombre != null' >
                        <li v-for='msj in aviso.error.nombre'>{{msj}}</li>
                    </ul>
                </div>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='apellido'>Apellido</label>
                    <input type='text' id='apellido' name='apellido' class='form-control' v-model='usuario.apellido' />
                    <ul class='list-error' v-if='aviso.error.apellido != null' >
                        <li v-for='msj in aviso.error.apellido'>{{msj}}</li>
                    </ul>
                </div>
            </div>

            <div class='row'>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='email'>Email</label>
                    <input type='text' id='email' name='email' class='form-control' v-model='usuario.email' />
                    <ul class='list-error' v-if='aviso.error.email != null' >
                        <li v-for='msj in aviso.error.email'>{{msj}}</li>
                    </ul>
                </div>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='clave'>Contraseña</label>
                    <input type='password' id='clave' name='clave' class='form-control' v-model='usuario.clave' />
                    <ul class='list-error' v-if='aviso.error.clave != null' >
                        <li v-for='msj in aviso.error.clave'>{{msj}}</li>
                    </ul>
                </div>
            </div>

            <div class='row'>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='fecha_nacimiento'>Fecha de nacimiento</label>
                    <input type='date' id='fecha_nacimiento' name='fecha_nacimiento' class='form-control' v-model='usuario.fecha_nacimiento' />
                    <ul class='list-error' v-if='aviso.error.fecha_nacimiento != null' >
                        <li v-for='msj in aviso.error.fecha_nacimiento'>{{msj}}</li>
                    </ul>
                </div>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='equipo'>equipo</label>
                    <select id='equipo' class='form-control' v-model='usuario.equipo'>
                        <option value='1'>Gryffindor</option>
                        <option value='2'>Hufflepuff</option>
                        <option value='3'>Ravenclaw</option>
                        <option value='4'>Slytherin</option>
                    </select>
                    <ul class='list-error' v-if='aviso.error.equipo != null' >
                        <li v-for='msj in aviso.error.equipo'>{{msj}}</li>
                    </ul>
                </div>
            </div>

            <div class='row'>
                <div class='group-form col-xs-12 col-md-6'>
                    <label for='imagen'>Imagen de avatar</label>
                    <input type='file' id='imagen' class='form-control' @change='leerAvatar' >
                </div>

                <div class='col-xs-3' v-if="usuario.avatar != null">
                    <p>Previsualización del avatar</p>
                    <img :src='usuario.avatar' alt='Previsualizacion' class='img-responsive img-circle'>
                </div>
            </div>

            <div class='row '>
                <button class='btn backgroundLinks btn-block'>Registrarse</button>
            </div>
            </form>
        </div>
</div>`,
    data: function(){
        return{
            usuario: {
                nombre: null,
                apellido: null,
                email: null,
                clave: null,
                fecha_nacimiento: null,
                equipo: null,
                avatar:null,
            },
            aviso: {
                error: {
                    nombre: null,
                    apellido: null,
                    email: null,
                    clave: null,
                    fecha_nacimiento: null,
                    equipo: null,
                },
                class: null,
                mensaje: null,
            }
        }
    },
    methods: {
/**
* Obtiene los datos de la imagen
* ingresada en el formulario
*/        
        leerAvatar: function(ev){
            const imgAvatar = ev.target.files[0];
            const reader = new FileReader();
            const self = this;
            reader.addEventListener('load', function(){
                self.usuario.avatar = reader.result
            });
            reader.readAsDataURL(imgAvatar);
        },
/**
* Envía la petición para
* guardar los datos del 
* nuevo usuario ingresado
*/        
        grabar: function(){
            fetch('../backend/public/api/usuarios' , {
                method: 'POST',
                body: JSON.stringify(this.usuario),
                 headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    }
            })
            .then(rta => rta.json())
            .then(data => {
                console.log(data);
                if(data.status == 2){
                    this.aviso.error = data.msj;
                }else if(data.status == 1){
                    this.aviso.class = "msj-error";
                    this.aviso.error = {
                        nombre: null,
                        apellido: null,
                        email: null,
                        clave: null,
                        fecha_nacimiento: null,
                        equipo: null,
                    };
                    this.aviso.msj = data.msj;
                }else if(data.status == 0){
                    this.aviso.class = null;
                    this.aviso.error = {
                        nombre: null,
                        apellido: null,
                        email: null,
                        clave: null,
                        fecha_nacimiento: null,
                        equipo: null,
                    };
                    this.aviso.msj = null;
                    
                    // VUELVO A LOGIN
                        this.$router.push('/login/creado');
                    
                }
            })
        }
    }
});
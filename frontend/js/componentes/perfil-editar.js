Vue.component('perfil-editar',{
    template: `<div>  
        <h2 class='text-center'>Editar usuario</h2>
        <div class='form-registro'>
            <div :class="aviso.class"><p>{{aviso.msj}}</p></div>
            <form @submit.prevent='editar'>
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

                <div class='col-xs-3' v-if="usuario.avatar != null && usuario.nuevaImagen == null">
                    <p>Previsualización del avatar</p>
                    <img :src='rutaImagen' alt='Previsualizacion' class='img-responsive img-circle previ'>
                </div>                

                <div class='col-xs-3' v-if="usuario.nuevaImagen != null">
                    <p>Previsualización del avatar</p>
                    <img :src='usuario.nuevaImagen' alt='Previsualizacion' class='img-responsive img-circle previ'>
                </div>
            </div>

            <div class='row'>
                <button class='btn btn-success btn-block'>Editar</button>
            </div>
            </form>
        </div>
</div>`,
    data: function(){
        return{
            usuario: {
                id: null,
                nombre: null,
                apellido: null,
                email: null,
                clave: null,
                fecha_nacimiento: null,
                equipo: null,
                avatar:null,
                nuevaImagen: null,
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
            },
        }
    },
    computed: {
        auth: function(){
            return store.auth;
        },
        rutaImagen:function(){
            return 'img/avatares/' + this.usuario.avatar;
        }
    },
    methods:{
/**
* Obtiene los datos de la
* imagen ingresada en el formulario
*/        
        leerAvatar: function(ev){
            const imgAvatar = ev.target.files[0];
            const reader = new FileReader();
            const self = this;
            reader.addEventListener('load', function(){
                self.usuario.nuevaImagen = reader.result
                self.usuario.avatar = reader.result
            });
            reader.readAsDataURL(imgAvatar);
        },
/**
* Envía la petición para editar
* los datos del usuario
*/        
        editar: function(){
            fetch('../backend/public/api/usuarios', {
                method: 'PATCH',
                body: JSON.stringify(this.usuario),
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
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
                        id: null,
                    };
                    this.aviso.msj = data.msj;
                }else if(data.status == 0){
                    this.$router.push('/perfil/'+ this.auth.id +'/usereditado');
                }
            })
        }
    },
    mounted: function(){
        // OBTENGO LOS DATOS
            this.usuario.id = this.auth.id;
            this.usuario.nombre = this.auth.nombre;
            this.usuario.apellido = this.auth.apellido;
            this.usuario.email = this.auth.email;
            this.usuario.clave = this.auth.clave;
            this.usuario.equipo = this.auth.equipo;
            this.usuario.avatar = this.auth.avatar;
            this.usuario.fecha_nacimiento = this.auth.fecha_nacimiento;
    }
});
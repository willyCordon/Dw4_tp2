Vue.component('login-page-form',{
    template: `<div>
        <div :class='status.class'>
            <p>{{status.message}}</p>
        </div>
        <form @submit.prevent='login'>
            <div class='form-group'>
                <input  type='email' 
                        id='email' 
                        name='email'
                        class='form-control'
                        v-model='auth.email'
                        placeholder='Email'
                >
            </div>            
            <div class='form-group'>
                <input  type='password' 
                        id='clave' 
                        name='clave'
                        class='form-control'
                        v-model='auth.clave'
                        placeholder='Contraseña'
                >
            </div>
            <button class='btn btm-default btn-block'>Ingresar</button>
            <router-link class='links'to='/registro'>Registrarse
            </router-link>
        </form>
</div>`,
    data: function(){
        return{
            auth:{
                email:null,
                clave:null,
            },
            status:{
                message: null,
                class: null,
            }
        }
    },
    methods:{
/**
* Envía la petición
* para loguear al usuario
*/        
        login:function(){

            fetch('../backend/public/api/login', {
                method: 'post',
                body: JSON.stringify(this.auth),
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
                .then( rta => rta.json() )
                .then( rta => {
                console.log(rta);
                    if(rta.status == 0){
                        store.auth = {
                            valid: true,
                            id : rta.data.id,
                            nombre : rta.data.nombre,
                            apellido : rta.data.apellido,
                            email : rta.data.email,
                            equipo : rta.data.equipo,
                            avatar : rta.data.avatar,
                            fecha_nacimiento : rta.data.fecha_nacimiento
                        };
                        this.auth = {
                            email: null,
                            clave: null
                        }
                        
                        this.$router.push('/');
                    }else if(rta.status == 1){
                        this.status.message = 'La contraseña ingresada es incorrecta.'
                        this.status.class = 'msj-error'
                    }else if(rta.status == 2){
                        this.status.class = 'msj-error'
                        this.status.message = 'El email ingresado es incorrecto.'
                    }
            })
            
        }
    },
});

Vue.component('login-page',{
    template: `<div>  
        <div class='row login-title text-center'>
            <h2>Bienvenido</h2>
            <p>Ingrese sus datos para poder poder disfrutar de contenido premium</p>
            <div v-if='aviso.msj != null' :class='aviso.class'><p>{{aviso.msj}}</p></div>
        </div>
        <div>
            <div class='col-xs-12 col-sm-6 col-sm-offset-3 login'>
                <login-page-form></login-page-form>
            </div>
        </div>

</div>`,
    data: function(){
        return{
            aviso: {
                msj: null,
                class: null,
            }
        }
    },
    mounted: function(){
        console.log(this.$route.params.msj)
        if(this.$route.params.msj){
            if(this.$route.params.msj == 'creado'){
                this.aviso.msj = 'Ha sido registrado exitósamente en nuestro sitio. Por favor ingrese su usuario y contraseña para empezar';
                this.aviso.class = 'msj-ok';
            }
        }
    }
});

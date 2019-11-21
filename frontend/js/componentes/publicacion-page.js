Vue.component('publicacion-page',{
    template: `<div>  
    <publicaciones-simples
        :publicacion='publicacion'
        :key='publicacion.id'
        @deleted='borrarPub'
    >
    </publicaciones-simples>

    <div id='comentarios-lista'>

        <comentarios-alta
            @creado = "nuevoComentario"
        >
        </comentarios-alta>

        <h2>Lista de comentarios</h2>
        <div class='sinComentarios' v-if='comentarios.length == 0'>
            <p>Por el momento nadie ha comentado este estado</p>
        </div>
        <publicacion-page-comentarios
            v-for='comentario in comentarios'
            :comentario='comentario'
            :key='comentario.id'
            @deleted='borrarComen'
        >
        </publicacion-page-comentarios>
    </div>


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
                },
            comentarios: [],
        }
    },
    mounted:function(){
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

            })
        // TRAIGO LOS COMENTARIOS
            fetch('../backend/public/api/comentarios/fil/' + this.$route.params.id , {
                credentials: 'include'
            })
            .then(rta => rta.json())
            .then(com => {
                this.comentarios = com;
            })

    },
    computed: {
        urlPerfilUsuario: function() {
            return '/perfil/' + this.publicacion.usuario.id;
        },
        urlVerPub: function(){
            return '/publicaciones/' + this.publicacion.id + '/ver';
        },        
        urlEditarPub: function(){
            return '/publicaciones/' + this.publicacion.id + '/editar';
        },
        auth: function(){
            return store.auth;
        }
    },
    methods:{
/**
* Envía la petición para
* eliminar una publicación.
*/        
        borrarPub: function(){
            let conf = confirm('¿Está seguro que desea borrar ésta publicación?');
            if(conf){
                fetch('../backend/public/api/publicaciones/' + this.publicacion.id, {
                    method:'DELETE',
                    credentials: 'include'
                })
                    .then(rta => rta.json())
                    .then(data => {
                        if(data.status == 0){
                            console.log('Publicacion Borrada')
                            this.$router.push('/perfil/' + this.auth.id + "/borrado" );
                        }    
                    })
            }
        },
/**
* Agrega el comentario nuevo
* a la lista que esta impresa
* en pantalla
*/        
        nuevoComentario: function(nuevo){
            this.comentarios.push(nuevo);
        },
/**
* Elimina el comentario de
* la lista que esta en pantalla
*/        
        borrarComen: function(borrado){
            this.comentarios = this.comentarios.filter(com => com.id !== borrado.id)
        }
    }
});
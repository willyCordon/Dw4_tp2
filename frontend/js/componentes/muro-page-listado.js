Vue.component('muro-page-listado',{
    template: `<div>  
                <publicaciones-alta
                    @creado="agregarPub"
                >
                </publicaciones-alta>
            <h2>Muro de publicaciones</h2>
            <publicaciones-simples
                v-for='publicacion in publicaciones'
                v-if="publicacion.privacidad == 'Todos' || publicacion.usuario == auth.id"
                :publicacion='publicacion'
                :key='publicacion.id'
                @deleted='borrarPub'
            >
            </publicaciones-simples>

</div>`,
    data: function(){
        return{
            publicaciones: [],
        }
    },
    computed: {
        auth: function(){
            return store.auth;
        },

    },
    mounted:function(){
        fetch('../backend/public/api/publicaciones', {
            credentials: 'include'
        })
        .then(rta => rta.json())
        .then(pubs => {
            this.publicaciones = pubs 
            this.publicaciones.reverse();
        })
    },
    methods: {
/**
* Agrega a la lista en pantalla
* los datos de la nueva publicación
*/        
        agregarPub:function(nuevo){
            this.publicaciones.unshift(nuevo);
        },
/**
* Elimina de la lista en pantalla
* la publicación que fue removida
*/        
        borrarPub: function(publi){
            console.log('Deleteado');
            this.publicaciones = this.publicaciones.filter(pub => pub.id !== publi.id)
        }
    }
});
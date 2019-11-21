Vue.component('muro-page-casas',{
    template: `<div>
        <div class='puntos'>
                <muro-page-casas-fila
                    v-for='equipo in equipos'
                    :equipo='equipo'
                    :key='equipo.id'
                >
                </muro-page-casas-fila>
               <a><router-link to="/posiciones">Ver todo</router-link></a> 
                
        </div>
    </div>`,
    computed:{
        equipos: function(){
            return store.equipos;
        }
    }
});
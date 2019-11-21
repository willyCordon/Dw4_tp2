// Vue.component('muro-page-equipos',{
//     template: `<div>
//         <div class='puntos'>
//                 <muro-page-equipos-fila
//                     v-for='equipo in equipos'
//                     :equipo='equipo'
//                     :key='equipo.id'
//                 >
//                 </muro-page-equipos-fila>
//                <a><router-link to="/posiciones">Ver todo</router-link></a> 
                
//         </div>
//     </div>`,
//     computed:{
//         equipos: function(){
//             return store.equipos;
//         }
//     }
// });
Vue.component('tabla-posiciones',{
    template: `<div>
    <div class='puntos'>
    <tabla-posiciones-fila
        v-for='equipo in equipos'
        :equipo='equipo'
        :key='equipo.id'
    >
    </tabla-posiciones-fila>
</div>
</div>`,
data: function() {
    return {
        equipos:[]    
    };
},
mounted: function(){
    fetch('../backend/public/api/equipos', {
        credentials: 'include'
    })
    .then(rta => rta.json())
    .then(equipos => {
        console.log(equipos);
        this.equipos = equipos;
    })
}
})
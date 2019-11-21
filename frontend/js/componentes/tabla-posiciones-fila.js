Vue.component('tabla-posiciones-fila',{
    template: `<div :class="equipo.nombre">
            <img  :src="'img/escudos/' + equipo.imagen" class='img-circle img-responsive escudos' />
            <h3>{{equipo.nombre}}</h3>
            <p>{{equipo.puntos}} puntos</p>
            </div>
</div>`,
    props: ['equipo'],
});
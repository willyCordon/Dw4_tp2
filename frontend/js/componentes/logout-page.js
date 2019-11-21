Vue.component('logout-page',{
    template: `<div>  
</div>`,
    mounted: function(){
        fetch('../backend/public/api/logout', {
            credentials: 'include'
        })
            .then( rta => rta.json() )
            .then( data => {
            store.auth = {
            id : '',
            email : '',
            nombre : '',
            apellido : '',
            avatar : '',
            equipo : '',
            fecha_nacimiento: '',
            valid: false,
                }
            this.$router.push('/');
        } )
    }
});

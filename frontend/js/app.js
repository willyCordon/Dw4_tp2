const routes = [   
    {
        path: '/login',
        component:{
            template:`<div><login-page></login-page></div>`
        }
    },
    {
        path: '/login/:msj',
        component:{
            template:`<div><login-page></login-page></div>`
        }
    },     
    {
        path: '/registro',
        component:{
            template:`<div><registro-form></registro-form></div>`
        }
    },    
    {
        path: '/logout',
        component:{
            template:`<div><logout-page></logout-page></div>`
        },
        meta:{
        requiresAuth:true
        }        
    },    
    {
        path: '/',
        component:{
            template:`<div><muro-page></muro-page></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/perfil',
        component:{
            template:`<div><perfil-page></perfil-page></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/posiciones',
        component:{
            template:`<div><tabla-posiciones></tabla-posiciones></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/perfil/editar',
        component:{
            template:`<div><perfil-editar></perfil-editar></div>`
        },
        meta:{
        requiresAuth:true
        }
    },       
    {
        path: '/perfil/:id',
        component:{
            template:`<div><perfil-page></perfil-page></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/perfil/:id/:msj',
        component:{
            template:`<div><perfil-page></perfil-page></div>`
        },
        meta:{
        requiresAuth:true
        }
    },    
    {
        path: '/publicaciones/:id/ver',
        component:{
            template:`<div><publicacion-page></publicacion-page></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/publicaciones/:id/editar',
        component:{
            template:`<div><publicaciones-editar></publicaciones-editar></div>`
        },
        meta:{
        requiresAuth:true
        }
    },
    {
        path: '/comentarios/:id/editar',
        component:{
            template:`<div><comentarios-editar></comentarios-editar></div>`
        },
        meta:{
        requiresAuth:true
        }
    }, 
];
const router = new VueRouter({
    routes: routes
});

const store = {
    auth:{
            id : '',
            email : '',
            nombre : '',
            apellido : '',
            avatar : '',
            equipo : '',
            fecha_nacimiento: '',
            valid: false,
    },
    equipos: [],
};

router.beforeEach((to,from, next) => {
    if(to.matched.some(record => record.meta.requiresAuth)){
        if(!store.auth.valid){
            next({
                path: '/login'
            });
        }else{
            next();
        }
        }else{
            next();
        }
});


const app = new Vue({
    el: '#app',
    router,
    data: store,
    mounted: function(){
        fetch('../backend/public/api/equipos/limit', {
            credentials: 'include'
        })
        .then(rta => rta.json())
        .then(equipos => {
            this.equipos = equipos;
        })
    }
});


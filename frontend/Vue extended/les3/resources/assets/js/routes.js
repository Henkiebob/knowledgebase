export default
[
   {
     path: '/cart',
     name: 'Cart',
     meta: {
      title: "Bierkrat - Bierwinkel"
     },
     component: require('./pages/Cart.vue')
  },
   {
     path: '/',
     name: 'Home',
     meta: {
      title: "Homepagina - Bierwinkel"
     },
     component: require('./pages/Home.vue')
  },
    {
    	path: '*',
    	name: 'Error 404',
      meta: {
        title: "Page not Found - Bierwinkel"
      },
    	component: { template: '<main><p>Page not found</p></main>' }
    }
];

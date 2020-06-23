//para que seja incluido no aquivo visual colocamos na tag id="app" e no final antes do </body> vamos incluir a meta-tag <script src=
//crio um component em resource/assets/js/componet de nome TestComponent.vue
require('./bootstrap');

window.Vue = require('vue');

//importando o snotify
import Snotify from 'vue-snotify'

//importação da router e o arquivo
import router from './routes/routers'
//importo o store
import store from './vuex/store' //coloco no vue.js
//declaro o App.vue q será direcionado pelo route-view e insiro o app-component no arquivo de view welcome
//substituo por adminComponent:
//Vue.component('app-component', require('./components/App'))
//admin/que é o nosso prefixo
Vue.component('admin-component', require('./components/admin/AdminComponent'))
//vou no arquivo de view welcome e troco a tag

//configurando
Vue.use(Snotify, {toast: {showProgressBar:false}})
//vamos coloca-lo no blade


//aqui declaro os componentes globais q posso usar em qualquer lugar inclusive nos nosso templets
//Vue é a variável criada lá em window.Vue e component(<aqui qualquer nome>), require('./o endereço do arquivo vue.js')

//Vue.component('test-component', require('./components/TestComponent.vue'))
//vou no welcome.blade.php e coloco a tag component

//importando as rotas não preciso colocar a estenção vue
//Vue.component('test-component', require('./components/TestComponent'))
//apago pois ñ existe mais e vou em admin criar um novo component

//component preloader
//para usá-lo de forma global coloco ele em welcome 
Vue.component('preloader-component', require('./components/layouts/PreloaderComponent'))

const app = new Vue({
	//inclui a const importada 
	//router: router, ou
	router,
	//agora lá em routers.js posso criar components e rotas
	//incluio o store
	store,
    el: '#app'
});
//para carregar as categorias
store.dispatch('loadCategories')


import Vue from 'vue'
import Vuex from 'vuex'

//importo 
import Categories from './modules/categories/categories'
//importar o preloader
import preloader from './modules/preloader/preloader'

Vue.use(Vuex)

//crio constante
//posso exportar o default assim: 
//export default store = new Vuex.Store({ 
//ou esportar a variável store
const store = new Vuex.Store({
	//passo as config, posso passar aqui várias stats, mutations, actions, gettes... mas é melhor separar tudo isso deixando mais limpo, pois trabalharemos com módulos	state: {}
	//portanto crio em vuex/modules/categories/
	modules: {
		//por si só não tem vínculo com o nosso start que é o app.js nem com o nosso boostrap.js então devemos incluí-lo no nosso view, vou no app.js
		categories: Categories,
		preloader

	}

})

//exportando a variável store
export default store


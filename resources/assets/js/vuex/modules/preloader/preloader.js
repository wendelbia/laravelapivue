export default {
	state: {
		//o status 
		loading: false, 
	},
	//o mutation vai mudar o estado para true
	//vou em categories.js
	mutations: {
		PRELOADER (state, status) {
			//o estado chama o status que recebe o tipo de status false o true
			state.loading = status
		}
	},
	/*actions: {
		//não precisa de nenhum actions 
		//vou em store.js para incluí-lo
	}*/
}
//módulo de categoria 
export default {
	//vou no CategoriesComponent e mudo a lógica
	//aqui são os estados que vou gerenciar
	state: {
		items: {
			//o data recebe um objeto vazio
			data: []
		},
	},
	//mutations é para alterar nossas state's
	mutations: {
		//criamos um mutations cujo nome: LOAD_CATEGORIES q recebe como default o state q é o proprio estado e recebe o que vou passar para ele q no caso é as cateogries
		LOAD_CATEGORIES (state, categories) {
			//aqui tenho o state que chama items que recebe o próprio retorno da api
			state.items = categories
			//vou no CategoriesComponent testar
		}

	},
	//controlar as ações como conunicações com api externas
	//busco o método da CategoriesComponent.vue
	//aqui irá fazer a requisição ajax
	actions: {
		//uma vez que deu certo passo para o mutations que vai alterar o nosso estado, ele pega o response e altera o nosso estado de items: {} por padrão o método action recebe o context

		loadCategories (context) {
			context.commit('PRELOADER', true)
			axios.get('/api/v1/categories')
				.then(response => {
					console.log(response)
					//vou chamar o mutations e passo para ele response q é o próprio retorno da api
					context.commit('LOAD_CATEGORIES', response)
				})
				.catch(errors => {
					console.log(errors)
				})
				//utilizo o finally, quando finaliza passa para false
				.finally(() => context.commit('PRELOADER', false))
		},

		//action para editar a categoria
		loadCategory (context, id) {
			context.commit('PRELOADER', true)
			//crio um objeto da PROMISE  cruio um callback 
			return new Promise((resolve, reject) => {
				//se retornar resolve deu certo posso retorna a flha também com reject
				//passo essa requisição ajax para dentro dele
				//aqui passo id da categoria assim: axios.post('/api/v1/categories' + id, params) ou 
				axios.get(`/api/v1/categories/${id}`)
				//se deu certo resolver response q é o próprio retorno da api
					.then(response => resolve(response.data))
				//se deu errado retorno o próprio erro reject(error)
					.catch(error => reject(error))
					.finally(() => context.commit('PRELOADER', false))
				})
			//em edit chamo esse action
		},



		//novo action para salvar dados inserir
		//posso retornar para o usuário se essas requisições deram certo 
		//utilizando o método PROMISSE do js
		storeCategory (context, params) {
			//utilizo o preloader
			context.commit('PRELOADER', true)

			//crio um objeto da PROMISE  cruio um callback 
			return new Promise((resolve, reject) => {
				//se retornar resolve deu certo posso retorna a flha também com reject
				//passo essa requisição ajax para dentro dele
				
				axios.post('/api/v1/categories', params)
				//se deu certo resolver
					.then(response => resolve())
				//se deu errado retorno o próprio erro reject(error)
					.catch(error => reject(error))
					.finally(() => context.commit('PRELOADER', false))
				})
				/* passo para dentro do Promise
			axios.post('/api/v1/categories', params)
				.then(response => {
					console.log(response)
				})
				.catch(errors => {
					console.log(error)
				})
				.finally(() => context.commit('PRELOADER', false))*/
		},
		//action para editar
		updateCategory (context, params) {
			//crio um objeto da PROMISE  cruio um callback 
			return new Promise((resolve, reject) => {
				//se retornar resolve deu certo posso retorna a flha também com reject
				//passo essa requisição ajax para dentro dele
				
				axios.put(`/api/v1/categories/${params.id}`, params)
				//se deu certo resolver
					.then(response => resolve())
				//se deu errado retorno o próprio erro reject(error)
					.catch(error => reject(error))
					.finally(() => context.commit('PRELOADER', false))
				})
		}
	},
	//recuperar nossas state's
	getters: {

	}
}
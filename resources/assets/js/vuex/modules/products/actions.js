/*posso criar uma constante e depois importá-lo no export default{}
const algo = {
	
}
export default {
	
}
ou exportar direto:
*/
import axios from 'axios'
import { URL_BASE } from '../../../config/configs'

const RESOURCE = 'products'

//propriedade para configuração dos readers
const CONFIGS = {
	headers: {
		'content-type': 'multipart/form-data',
	}

}

export default {
	//incluo mais um parêmetro para a paginação simples
	//loadProducts (context) {
	loadProducts (context, params) {
		//trabalho aqui com o preloader
		context.commit('PRELOADER', true)
		//passo o verbo http o get
		//caso mude a versão, crio um apasta config 
		//axios.get(URL_BASE + 'products') pode concatenar assim também:
		//axios.get(`${URL_BASE}products`) posso receber products na const:
		//incluindo mais uma parâmetro para paginação
		//axios.get(`${URL_BASE}${RESOURCE}`)
		axios.get(`${URL_BASE}${RESOURCE}`, {params})
		//response q é o retorno
		//confirmo a mudança
		//comitar:fazer permanentes um conjunto de mudanças experimentais. 
		//chamo a action
			.then(response => context.commit('LOAD_PRODUCTS', response.data))
			.catch(error => console.log(error))
			//chamo assa action no ProductsComponent

			//preloader
			.finally(() => context.commit('PRELOADER', false))
	},
	//irá carregar o modal para popular os input's para editar
	loadProduct (context, id) {
		//trabalho aqui com o preloader
		context.commit('PRELOADER', true)

		return new Promise((resolve, reject) => {
		axios.get(`${URL_BASE}${RESOURCE}/${id}`)
		//resolve que é o do Promise passando o response.data q é o item em si se debugar retornará um ponto data
		//retorna o response com o resolve que tem todos os dados do product
			.then(response => resolve(response.data))
 			//se der erro retornará o reject()
			.catch(error => reject())
			.finally(() => context.commit('PRELOADER', false))
		})
	},
/*vamos mudar para adptá-lo para o formData e acrescentamos o upload de imagem
	storeProduct (context, params) {
		context.commit('PRELOADER', true)

		return new Promise((resolve, reject) => {
			axios.post(`${URL_BASE}${RESOURCE}`, params)
				.then(response => resolve())
				.catch(error => reject(error.response))
				//.finally(() => context.commit('PRELOADER', false))
		})
	},
*/

	storeProduct (context, formData) {
		context.commit('PRELOADER', true)

		return new Promise((resolve, reject) => {
			//para o upload de imagem preciso passar um 3º parâmetro de imgagem para especificar que é a configuração de reader, criamos uma var lá em cima que são as configurações
			//confiro na pasta storage se foi inserido algum arquivo
			axios.post(`${URL_BASE}${RESOURCE}`, formData, CONFIGS)
				.then(response => resolve())
				.catch(error => reject(error.response))
				//.finally(() => context.commit('PRELOADER', false))
		})
	},


	//updateProduct (context, params) {
		//vamos mudar para atualizar a imagem
		updateProduct (context, formData) {
		context.commit('PRELOADER', true)
		//para usar um parâmetro adicional, uso o append 
		formData.append('_method', 'PUT')
		return new Promise((resolve, reject) => {
			//axios.put(`${URL_BASE}${RESOURCE}/${params.id}`, params)
			//para pegar o id do produto tenho que usar o get por usar a classe formData e preciso usar a requisição do tipo post para isso uso um parâmetro adicional 
			axios.post(`${URL_BASE}${RESOURCE}/${formData.get('id')}`, formData)
				.then(response => resolve())
				.catch(error => {
					context.commit('PRELOADER', false)
					reject(error.response)
				})
				//.finally(() => context.commit('PRELOADER', false))
		})
	},

	destroyProduct (context, id) {
		context.commit('PRELOADER', true)
		return new Promise((resolve, reject) => {
			axios.delete(`${URL_BASE}${RESOURCE}/${id}`)
				.then(response => resolve())
				//dando erro, é bom finalizar o preload no catch
				.catch(error => {
					reject()
					context.commit('PRELOADER', false)
				})
				//.finally(() => context.commit('PRELOADER', false))
		})

	}
}
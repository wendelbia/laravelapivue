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
			.then(response => resolve(response.data))
 			//se der erro retornará o reject()
			.catch(error => reject())
			.finally(() => context.commit('PRELOADER', false))
		})
	},

	storeProduct (context, params) {
		context.commit('PRELOADER', true)

		return new Promise((resolve, reject) => {
			axios.post(`${URL_BASE}${RESOURCE}`, params)
				.then(response => resolve())
				.catch(error => reject(error.response))
				.finally(() => context.commit('PRELOADER', false))
		})
	}
}
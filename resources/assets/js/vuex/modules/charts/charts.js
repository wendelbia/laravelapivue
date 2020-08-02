import { URL_BASE } from "../../../config/configs"

export default {
	state: {

	},

	actions: {
		reportsProducts (context, params) {
			context.commit('PRELOADER', true)
			//chamo a api através da URL_BASE e rota
			return axios.get(`${URL_BASE}reports-products`, params)
							.finally(() => context.commit('PRELOADER', false))
		}
	}
}
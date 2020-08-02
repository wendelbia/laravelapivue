
import { NAME_TOKEN } from '../../../config/configs'

export default {
	state: {
		//me é o proprio dado do usuário como email nome etc...
		me: {},
		//que verifica se o usuário está logado por default não está
		authenticated: false,
		//para o redirecionamento de um proposital recarregamento de pág
		urlBack: 'home',
	},

	mutations: {
		//vmaos mudar os estados
		AUTH_USER_OK (state, user) {
		//vamos mudar o estado de false para true
		state.authenticated = true,
		//e de me para user que é o segundo parâmetro
		state.me = user	
		},
		//crio uma mutation para mudar a url
		CHANGE_URL_BACK (state, url) {
			//pego a url que estava para ir na que eu quero redirecionar no caso -> url
			state.urlBack = url
		},

		AUTH_USER_LOGOUT (state) {
			//pego o me em estado atual
			state.me = {}
			//pego a authent no vl de falsa q é o vl padrão
			state.authenticated = false
			//pego para resetar
			state.urlBack = 'home'




		}
	},

	actions: {
		//vamos fazer nosso requisição ajax para validar os dados do usuário
		login (context, params) {
			context.commit('PRELOADER', true)
			//para debugar:
			//console.log(params)
			return axios.post('/api/auth', params)
				//para verificação:
				//.then(response => console.log(response))
				.then(response => {
					context.commit('AUTH_USER_OK', response.data.user)

					//paracorrigir o bug no primeiro login 
					const token = response.data.token

					//após descomentar nam router/api.php o middleware
//quando faço o login não vou só injetar dados no state para o mutation
//para continua logado após recarregar a página tenho que pegar o token no storage
//em js/component/config/config.js exporto uma constant NAME_TOKEN
//aqui armazeno o token no localStorage pego o método setItem para setar o item passo como parâmetro o naome do token em NAME_AUTH feito em configs.js  usando o response.data para isso
//indo no browser no login f12 aplication storage/aplication dois de logado aparecerá o nome do token e seu respectivo valor lá ele salva uma informação com o key de nome NAME_AUTH e o valor (value)então vou verifica se já existe, faço isso em app.js
					//localStorage.setItem(NAME_TOKEN, response.data.token)	
					//para a correção do primeiro login passo o token
					localStorage.setItem(NAME_TOKEN, token)	//e passo esse token também no header do axios la no booststrap.js, copio de lá
					window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`//e agora adiciono o perfil do usuário
				})
				//.catch(error => console.log(error))
				//vamos retornar os dados do retorno q é o feedback do erro
				//.catch(error => reject(error.response.data)) 
				//vamos deixar o objeto vazio para retornar no LoginComponent um catch informando problemas no login do usu 
				.finally(() => context.commit('PRELOADER', false))
		},
		/*função para verificar se usu está logado*/
		checkLogin (context) {
			context.commit('PRELOADER', true)
			//uso o Promise para retorno de erro
			return new Promise((resolve, reject) => {
				//uso uma constante para receber o token busco pelo localSotorage
			const token = localStorage.getItem(NAME_TOKEN)
			//se não houver
			if (!token)
				//para mostrar que não tem o token
				return reject()
				//se exite esse token faço uma requisição na api para este usu autenticado, ou seja o usuário dono do token do NAME_TOKEN em api.php tem uma lógica q retorna os dados do usu autenticado
				axios.get('/api/me')
					.then(response => {
						//podemos debugar com console.log(response.data.user) q veremos esses dados
						//já tendo os dados do usu posso chamar o mutation e passa os dados do usu
						context.commit('AUTH_USER_OK', response.data.user)
						//se deu certo retono o ersolve
						resolve()
					})
					//se deu errado retorno um reject
					.catch(() => reject())
					.finally(() => context.commit('PRELOADER', false))
					
			})
		},

		logout (context) {
		//para isso posso deletar o token lá no localstorage
		localStorage.removeItem(NAME_TOKEN)
		
		//chamo o mutation
		context.commit('AUTH_USER_LOGOUT')
		}
	},
}
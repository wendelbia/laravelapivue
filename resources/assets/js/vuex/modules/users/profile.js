import { NAME_TOKEN } from '../../../config/configs'
//vamos criar actions fora do export para observar diferentes maneiras de trabalhar
const actions = {
	//aqui colocos nossas actions
	//a primeira será que fará o registro do user e vou registrar o nosso modulo no store.js
	//faço a requisição ajax para receber os parâmetros
	register (context, params) {
		//para não fazer o cadastro 2 vezes faço preloader
		context.commit('PRELOADER', true)
		//pego lá em routes/api.php o caminho da api que é register do tipo post, (posso fazer um arquivo config para isso também), e passo os parâmetros que são os dados que serão colocados no input, se fosse um cadastro simples utilizaria o return axios... mas será usado Promise para ter um retorno mais preciso, passo como params resolve(resolv) e rejeita(reject)
		return new Promise((resolve, reject) => {
			axios.post('/api/register', params)
					//para 
					//.then(response => console.log(response))
					.then(response => {
						//aqui chamo o mutation AUTH_USER_OK  e passo os dados do usu que acabou de acessar
								context.commit('AUTH_USER_OK', response.data.user)

					//paracorrigir o bug no primeiro registro armazno o primeiro token na constante 
					const token = response.data.token
					localStorage.setItem(NAME_TOKEN, token)	//e passo esse token também no header do axios la no booststrap.js, copio de lá
					window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`//e agora adiciono o perfil do usuário

					//retorno pra ver se deu certo
					resolve()
				
					})
					//para pegar os erros
					//.catch(error => console.log(error.response.data))
					//tiro o console.log e uso o reject e passo os erros que são mostrados no console do browse
					.catch(error => reject(error.response.data)) 
					//finalizo o preloader
					.finally(() => context.commit('PRELOADER', false))
		})
	},

	update (context, params) {
		//para não fazer o cadastro 2 vezes faço preloader
		context.commit('PRELOADER', true)
		//pego lá em routes/api.php o caminho da api que é register do tipo post, (posso fazer um arquivo config para isso também), e passo os parâmetros que são os dados que serão colocados no input, se fosse um cadastro simples utilizaria o return axios... mas será usado Promise para ter um retorno mais preciso, passo como params resolve(resolv) e rejeita(reject)
		return new Promise((resolve, reject) => {
			axios.put('/api/update', params)
					//para 
					//.then(response => console.log(response))
					.then(response => {
						//aqui chamo o mutation AUTH_USER_OK  e passo os dados do usu que acabou de acessar
								context.commit('AUTH_USER_OK', response.data.user)
					//retorno pra ver se deu certo
					resolve()
				
					})
					//para pegar os erros
					//.catch(error => console.log(error.response.data))
					//tiro o console.log e uso o reject e passo os erros que são mostrados no console do browse
					.catch(error => reject(error.response.data)) 
					//finalizo o preloader
					.finally(() => context.commit('PRELOADER', false))
		})
	}


}

export default {
	//não precisamos importar states pois vammos trabalhar com actions
	//actions: {}
	//aqui importo as actions
	actions,
}



					//após descomentar nam router/api.php o middleware
//quando faço o login não vou só injetar dados no state para o mutation
//para continua logado após recarregar a página tenho que pegar o token no storage
//em js/component/config/config.js exporto uma constant NAME_TOKEN
//aqui armazeno o token no localStorage pego o método setItem para setar o item passo como parâmetro o naome do token em NAME_AUTH feito em configs.js  usando o response.data para isso
//indo no browser no login f12 aplication storage/aplication dois de logado aparecerá o nome do token e seu respectivo valor lá ele salva uma informação com o key de nome NAME_AUTH e o valor (value)então vou verifica se já existe, faço isso em app.js
					//localStorage.setItem(NAME_TOKEN, response.data.token)	
					//para a correção do primeiro login passo o token
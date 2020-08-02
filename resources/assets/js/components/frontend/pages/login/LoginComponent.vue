<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-8">
				<div class="card">
					<div class="card-header">
					Login
				</div>
				<div class="card-body">
					<form class="form" @submit.prevent="login">
					<div class="form-group">
						<input type="email" v-model="formData.email" class="form-control" placeholder="E-mail">
					</div>
					<div class="form-group">
						<input type="password" v-model="formData.password" class="form-control" placeholder="senha">
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success">Acessar</button>
						<!--no to faço o bind com : pontos e uso o método name:-->
						<router-link :to="{name: 'register'}">Não tem cadastro? Registre-se</router-link>
					</div>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data () {
			return {
				formData: {
					email: '',
					password: '',

				}
			}
		},

		methods: {
			//preciso criar a action no vuex e chamar a state no store.js
			login () {
			//chamo a action do nosso modulles/auth/auth.js
			//this que é a referência do vue.js e $store que é o nosso vuex  
				this.$store.dispatch('login', this.formData)
				//posso fazer um retorno ja q na action eu retorno então retorno um redirecionamento
							.then(() => this.$router.push({name: 'admin.dashboard'}))	
							//vamos fazer um alert para o usu saber q o login não deu certo
							.catch(() => {
								//como ñ recebi nada como parâmetro passo um this como notificação do tipo error
								this.$snotify.error('Dados inválidos', 'Falha ao acessar')
							})
			}
		}
	}
</script>
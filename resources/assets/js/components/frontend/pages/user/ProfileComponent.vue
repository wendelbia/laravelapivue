<template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-8">
				<div class="card">
					<div class="card-header">
					Atualizar Perfil
					</div>
					<div class="card-body">
						<form class="form" @submit.prevent="updateProfile">
							<user-form :user="formData" :errors="errors"></user-form>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>


<script>
	import UserForm from './UserForm'
	export default {
		//propriedade computada
		computed: {
			formData () {
				return this.$store.state.auth.me 
			}
		},
		data () {
			return {
				/*formData: {
					name: '',
					email: '',
					password: '',
				},
				vai pegar os erros por default retorna vazio*/
				errors: {}
			}
		},
		methods: {
			updateProfile () {
				//chamo a action que foi criada no profile.js
				//como params passo os dados do formData
				//aqui vai disparar a action update que tem como params os dados do formulário submetido
				this.$store.dispatch('update', this.formData)
				//é feito o two-way-data-bind, oq o user coloca no formulário é sincronizado 
				//agora retorno o then
						.then(() => {
							//se teve sucesso then nos envia para a dashboard
							this.$router.push({name: 'admin.dashboard'})
							//com a mensagem de sucesso
							this.$snotify.success('Atualizado com sucesso!')
						})
						//senão mostra os erros
						.catch(response => {
							//vai retornar os erros
							//errors recebe o os erros
							this.errors = response.errors
						})
			}
		},

		components: {
			UserForm
		} 
	}
</script>
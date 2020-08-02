<template>
	<div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-8">
				<div class="card">
					<div class="card-header">
					Cadastrar-se
				</div>
				<div class="card-body">
					<form class="form" @submit.prevent="register">
						<user-form :user="formData" :errors="errors"></user-form>
					</form>
				</div>
				</div>
			</div>
		</div>
	</div>
	</div>
</template>

<script>
import UserForm from './UserForm'

	export default {
		data () {
			return {
				formData: {
					name: '',
					email: '',
					password: '',
				},
				//vai pegar os erros por default retorna vazio
				errors: {}
			}
		},
		methods: {
			register () {
				//chamo a action que foi criada no profile.js
				//como params passo os dados do formData
				this.$store.dispatch('register', this.formData)
				//é feito o two-way-data-bind, oq o user coloca no formulário é sincronizado 
				//agora retorno o then
						.then(() => {
							this.$router.push({name: 'admin.dashboard'})
							this.$snotify.success('Sucesso ao cadastrar!')
						})
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
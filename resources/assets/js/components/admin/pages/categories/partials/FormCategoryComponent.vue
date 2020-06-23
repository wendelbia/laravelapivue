<template>
	<div>
		<!--escuto o evento submit-->
		<form class="form" @submit.prevent="onSubmit">
			<!-- usando has podemos formatar o css-->
			<div :class="['form-group', {'has-error': errors.name}]">
				<!--no console do browse tenho o name que recebe o array que tem as propriedades do campo name que na posição zero tem o item que é a mensagem de erro faço um if para exibir a mensagem, ele mostra um erro de cadas vez, vamos pegar o da posição zero-->
				<div v-if="errors.name">{{ errors.name[0] }}</div>
				<input type="text" v-model="category.name" class="form-control" placeholder="Nome da categoria">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	props: {
		category: {
			require: false,
			type: Object|Array,
			default: () => {
				return {
					//esse id é para a pág. editar que vai buscar pelo id
					id: '',
					name: '',
				}
			}
		},
		/**/
		updating: {
			require: false,
			type: Boolean,
			default: false,
		}
	},
	//crio o data para a notificação de erro
	data () {
		return {
			//deixo vazio
			errors: {}
		}
	},
	methods: {
		onSubmit () {
			const action = this.updating ? 'updateCategory' : 'storeCategory'
			//this.$store.dispatch('action', this.category)
			this.$store.dispatch(action, this.category)
				//utilizando a Promise feita em categories.js para redirecionamento da página
				//então chamo a rota uso o nome da rota poderia passar o caminho mas uso o name:
							//.then(() => this.$router.push({name: 'admin.categories'}))
							//agora com o notify
							.then(() => {
								this.$snotify.success('Sucesso ao cadastrar')

								this.$router.push({name: 'admin.categories'})
							})
							.catch(error => {
								//console.log('FormCategoryComponent')
								//agora com snotify, o segundo parâmetro é o tipo de mensagem
								this.$snotify.error('Algo Errado', 'Erro')


								//preciso pegar o response que retorna o erro e o data. que é o dado retornado e o errors q é a mensagem de erro
								console.log(error.response.data.errors)
								//pego a propriedade erros para armazanar o objeto nela
								this.errors = error.response.data.errors
							})
		}
	}
}
</script>

<style scoped>
.has-error{color: red;}
.has-error input{border: 1px solid red;}
</style>
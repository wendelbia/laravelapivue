<template>
	<div>
		<h1>Editar Categoria <b>{{category.name}}</b></h1>
		<form-cat 
			:category="category":updating="true">
		</form-cat>
		<!--escuto o evento submitenvio esse formulário para partials/FormCategory...	
		<form class="form" @submit.prevent="submitForm">
			<div class="form-group">
				<input type="text" v-model="category.name" class="form-control" placeholder="Nome da categoria">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</form>-->
	</div>
</template>
<script>
import FormCategoryComponent from './partials/FormCategoryComponent'

	export default {
		props: {
			id: {
				//é obrigatório informar é require:
				require: true
				//vou na rota e adiciono o props que são valores dinâmicos
			}
		},
		//próximo passo carregar a categoria
		//consultar a api para trazer a categoria pelo id
		//poderia usar o axio mas não é o correto vamos usar a action crioaremos uma então
		//uso o cerated() para a action ser utilizada
		created () {

			//passo tudo isso para o methods: { ... }
			//this.id é o da props loadCategory
			/*this.$store.dispatch('loadCategory', this.id)
							.then(response => this.category = response)
							.catch(error => {
								console.log(error)
							})
			/*this.$store.dispatch('loadCategory', this.id)
							.then(response => this.category = response)
							.catch(error => {
								console.log(error)
							}) e agora chamo o método*/
			this.loadCategory()
		},
		/*crio o nosso data que pega dos dados da categoria lá no formaulário*/
		data () {
			return {
				category: {}
			}
		},
		methods: {
			loadCategory () {
				//this.id é o da props loadCategory
			this.$store.dispatch('loadCategory', this.id)
							.then(response => this.category = response)
							.catch(error => {
								//console.log(error)
								//agora uso o snotify
								this.$snotify.error('Categoria não encontrada', '404')
								//e redireciono além da mensagem
								this.$router.push({name: 'admin.categories'})

							})
			/*this.$store.dispatch('loadCategory', this.id)
							.then(response => this.category = response)
							.catch(error => {
								console.log(error)
							})*/
			}
		},
		components: {
			formCat: FormCategoryComponent
		}
	}
</script>

<style scoped>

</style>
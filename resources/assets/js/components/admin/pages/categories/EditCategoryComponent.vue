<template>
	<div>
		<h1>Editar Categoria <b>{{category.name}}</b></h1>
		<form-category-component 
			:category="category" 
			:update="true">
		</form-category-component>
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
			//this.id é o da props loadCategory
			this.$store.dispatch('loadCategory', this.id)
				.then(response => {
				    console.log(response)
				    this.category = response
				})
				.catch(error => {
				    console.log(error)
				})
		},
		/*crio o nosso data que pega dos dados da categoria lá no formaulário*/
		data () {
			return {
				category: {}
			}
		},
		components: {
			FormCategoryComponent
		}
	}
</script>
<style scoped>
</style>

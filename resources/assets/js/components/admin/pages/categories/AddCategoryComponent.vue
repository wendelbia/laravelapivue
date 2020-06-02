<template>
	<!--crio a rota para acessar esse component router.js -->
	<div>
		<h2>
			Adicionar nova categoria
		</h2>
		<!--escuto o evento submit
		<form class="form" @submit.prevent="submitForm">
			<div class="form-group">
				<input type="text" v-model="name" class="form-control" placeholder="Nome da categoria">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Enviar</button>
			</div>
		</form>
		envio esse formulário para partials/FormCategoryComponent.vue-->
		<form-cat></form-cat>
				
	</div>
</template>

<script>
import FormCategoryComponent from './partials/FormCategoryComponent'
	

	export default {

		components: {
			formCat: FormCategoryComponent
		}
		/*não precisa mais ter esse método passo tudo para FromCateg...
		para recuperar os dados do form
		data () {
			return {
				name: ''
			}
		},
		//vou no vuex que é a forma correta de trabalhar deixando por lá essa responsabilidade para persistir os dados
		//podemos tratar erros validações vamos em categoris.js 
		methods: {
			submitForm () {
				this.$store.dispatch('storeCategory', {name: this.name})
				//utilizando a Promise feita em categories.js para redirecionamento da página
				//então chamo a rota uso o nome da rota poderia passar o caminho mas uso o name:
								.then(() => this.$router.push({name: 'admin.categories'}))
								.catch()
			}
		},*/
		
	}
</script>

<style scoped>
	
</style>
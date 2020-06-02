<template>
	<div>
		<!--escuto o evento submit-->
		<form class="form" @submit.prevent="onSubmit">
			<div class="form-group">
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
	methods: {
		onSubmit () {
			const action = this.updating ? 'updateCategory' : 'storeCategory'
			//this.$store.dispatch('action', this.category)
			this.$store.dispatch(action, this.category)
				//utilizando a Promise feita em categories.js para redirecionamento da página
				//então chamo a rota uso o nome da rota poderia passar o caminho mas uso o name:
							.then(() => this.$router.push({name: 'admin.categories'}))
							.catch()
		}
	}
}
</script>

<style scoped>
	
</style>
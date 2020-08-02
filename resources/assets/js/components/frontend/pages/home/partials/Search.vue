<template>
	<div>
		<form class="form form-inline" @submit.prevent="search">
			<select class="form-control" v-model="category_id">
				<option value="">Selecione a Categoria</option>
				<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
			</select>
			<!-- uso o two-way data-bind que é o filter do data() { ... -->
			<input type="text" v-model="filter" placeholder="Pesquisar:" class="form-control mr-sm-2">

			<button type="submit" class="btn btn-outline-success">Pesquisar</button>
		</form>
	</div>
</template>

<script>
export default {
	data () {
		return {
			//retornar vazio
			filter: '',
			category_id: '',
		}
	}, 

	computed: {
		categories () {
			return this.$store.state.categories.items.data
		}
	},

	methods: {
		//quando submiter o formulãrio  chamo o emit ele envia uma ação para o component pai q no caso é o nosso CategorieComponent
		search () {
			//passo o parâmetro o filter
			//não passo agora só o meu filter do product mas o category também
			//this.$emit('search', this.filter)
			this.$emit('search', {
				filter: this.filter,
				category_id: this.category_id
			})
		}
	}
}
</script>
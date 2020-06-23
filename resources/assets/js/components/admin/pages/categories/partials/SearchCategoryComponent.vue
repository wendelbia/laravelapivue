<template>
	<div>
		<form class="form form-inline" @submit.prevent="search">
			<!-- uso o two-way data-bind que é o filter do data() { ... -->
			<input type="text" v-model="filter" placeholder="Pesquisar:" class="form-control mr-sm-2">
			<button type="submit" class="btn btn-outline-success">Pesquisar</button>
			<!---->
			<div v-if="filter">
				<p>Resultados para: {{ filter }}</p>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	data () {
		return {
			//retornar vazio
			filter: ''
		}
	}, 
	methods: {
		//quando submiter o formulãrio  chamo o emit ele envia uma ação para o component pai q no caso é o nosso CategorieComponent
		search () {
			//passo o parâmetro o filter
			this.$emit('searchCategory', this.filter)
		}
	}
}
</script>
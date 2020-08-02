<template>
	<div>
		<!--se tiver produto no carrinho-->
		<div v-if="notCart">
			<!--click: evento para enviar produto para o carrinho-->
		<button class="btn btn-info" @click.prevent="addCart">
			Adicionar Produto
		</button>
		</div>

		<div v-else>
			<!--se tiver o produto no carrinho vou mostar a opção remover do carrinno-->
		<button class="btn btn-danger" @click.prevent="removeCart">
			Remover Produto
		</button>
		</div>
	</div>
</template>

<script>
export default {
	props: ['product'],

	//através da propiedade vou verificar se o produto está ou não no carrinho
	computed: {
		notCart () {
			//o indexOf() retorna o índice do item no array, quando não encotra retorna -1, se for maior q zero retorna true senão zero falso
			return this.$store.state.cart.products.indexOf(this.product) < 0
		}
	},
	//metodo para enviar o produto para o carrinho
	methods: {
		//vamos na mutation para quando clicar no evento adicionar no carrinho
		addCart () {
			//console.log(this.product)
			this.$store.commit('ADD_PRODUCT_CART', this.product)
		},

		removeCart (){
			this.$store.commit('REMOVE_PRODUCT_CART', this.product) 
		}
	}
}
</script>
<template>
	<div><!---->
		<h1>{{ product.name }}</h1>
			<div v-if="product.image">
			    <img :src="[`/storage/products/${product.image}`]" :alt="product.name" class="img-list">
			</div>
			<div v-else>
				<img src="/imgs/no-image.webp" :alt="product.name" class="img-list">
			</div>
			<div>
				{{ product.description }}
			</div>
	</div>
</template>

<script>

export default {
	//tendo o id do produto  na props já posso fazer o load, o id q está lá na  url vou receber como parâmetro aqui na props
	props: ['id'],

	//vamos chamar o loadProduct assim que o component for criado
	created () {
		this.loadProduct()
	},

	/*criamos uma propriedade product que é um objeto vazio*/
	data () {
		return {
			product: {}
		}
	},

	methods: {
		//esse método recebe o id do produto que então vai fazer o load
		loadProduct () {
			//chamo o $store e uso a action que carrega o produto pelo id
			this.$store.dispatch('loadProduct', this.id)
			//como retorno armazeno uma propriedade chamada product
			//.then(response => this.product = response.product)
			.then(product => this.product = product.product)
		}
	}
}
</script>
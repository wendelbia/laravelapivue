<template>
	<div>
		<h1>Produtos</h1>
		<!--temos um component de pesquisa que despara o $emit chamado @search que é o evento que despara lá e recebe o search daqui que é o método-->
		<search
		@search="search"></search>

		<div class="row">
			<!--vamos busca no component Item o :item  que receberá o product e o :path que é o caminho-->
			<item 
				v-for="product in products.data" 
				:key="product.id"
				:item="product"
				:path="'products'">
			</item>
		</div>
		<hr>
		<!---->
			<paginate
				:pagination="products"
				@paginate="loadProducts">
			</paginate>
	</div>
</template>

<script>
	//importar paginaçãp
	import PaginationComponent from '../../../layouts/PaginationComponent'
	import Item from '../../../layouts/Item'
	//foi criado dentro do home/partial um component de pesquisa para substituir esse
	//import SearchComponent from '../../../admin/layouts/SearchComponent'
	import Search from './partials/Search'

export default {
/*devemos analisar se é melhor carregar os produtos na página pois cada caso um caso, se for usar em várias páginas então sim, pode ser colocado no app.js como foi feito em admin/poduct, nós já temos o nosso vuex que carrega todos os nosso produtos, eu posso fazer o load desses produtos fazendo a requsição pela api que assim tenho a lista atualizada ou carregar pelo vuex q não será peciso fazer o load
O analisamos, se for um sistema de grandes cadastros é melhor o load que faça o load na api, mas se for um site de pequeno volume de dados é recomendado buscar esse dados no vuex, caso esse data esteja diferente de vazio >data Array[0] aí é consultado a api, caso contrário é buscado no vuex, esse é o cenário que se deve estar atento para trabalhar
*/
	created () {
	//se o produto que estão disponíveis através do vuex (usando o length para saber a quantidade) for igual a zero então carrego os produtos pela api
		if (this.products.data.length == 0)
			//temos uma action de faz isso que a loadPruducts
			this.$store.dispatch('loadProducts', {})

	},
	//crio uma propriedade filter para a filtragem
	data () {
		return {
			filter: '',
			category_id: '',
		}
		
	},
	//crio uma propriedade computada para retornar os produtos do vuex
	computed: {
		products () {
			//e essa propriedade vai retornar o this que é o próprio referência do vue.js, store que é referência do vuex e pego o state, products e items assim tenho o retorno dos produtos em si, assim já posso pegar os produtos e fazer uma listagem
			return this.$store.state.products.items
		},
		//para a filtragem crio uma propriedade computada 
		params () {
			return {
				filter: this.filter,
				//acrescento o category_id para pesquisar category
				category_id: this.category_id,
				//a page receber o current_page q é a página atual
				page: this.products.current_page, 
			}
		}
	},

	methods: {
		loadProducts (page = 1) {
			//por causa da filtragem daqui não passo mais 
			//this.$store.dispatch('loadProducts', {page: page})
			//passo agora this.params
			this.$store.dispatch('loadProducts', {...this.params, page})
		},
//nesse método vamos receber como parâmtro o que a pessoa digitar no input da pesquisa e o data() {} vai receber		
	search (values) {
		this.filter = values.filter
		this.category_id = values.category_id
		//no momento preciso carreaga a página novamente
		this.loadProducts()
	}

	},

	components: {
		paginate: PaginationComponent,
		Item,
		//search: SearchComponent
		Search,
	}
}
//em Product.php e adiciono mais um filtro
</script>
<template>
	<div>
		<h1>Listagem de Produtos</h1>

		<div class="row">
			<div class="col">
				<button class="btn btn-success" @click.prevent="showModal = true">
					Novo
				</button>
				<!--
					show: mostra o modal
					animation: tipo de animação
					hide: esconde o modal
					width: largura
					heigth: altura
					---
					Vamos fazer o cadastro fora daqui para q não fique tão pesado
				-->
				<vodal
				:show="showModal"
				animation="zoom"
				@hide="hideModal"
				:width="700"
				:height="600">
				<!--evento para fechar o modal
					passo o product que por default sempre vou estar passando esse valores vazios lá do data(){}
					update está enviando o valor de false
				-->
				<product-form
				:product="product"
				:update="update"
				@success="success">
				</product-form>	
				</vodal>
			</div>
			<div class="col">
				<search @search="searchForm"></search>
			</div>
		</div>

		<table class="table table-dark">
			<thead>
				<tr>
					<th>Imagem</th>
					<th>Nome</th>
					<th width="200">Ações</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="product in products.data" :key="product.id">
					<td>...</td>
					<td>{{ product.name }}</td>
					<td>
						<!--editar produto pego pelo id crio o método-->
						<a href="#" @click.prevent="edit(product.id)" class="btn btn-info">Editar</a>
						<a href="#" class="btn btn-danger">Deletar</a>
					</td>
				</tr>
			</tbody>
		</table>
		<pagination
		 :pagination="products"
		 :offset="6"
		 @paginate="loadProducts">
		 </pagination>
<!--tirando o código para adicionar o component PaginationComponent
se a últama página for maior do que 1
		<ul v-if="products.last_page > 1">
			aqui só vou apresentar a página atual se ela for < que 1 pois não faz sentido voltar para a páina zero
			<li v-if="products.current_page > 1">-->
				<!--pego a página atual menos 1
				<a href="#" @click.prevent="loadProducts(products.current_page - 1)">
					Anterio
				</a>
			</li>-->
			<!--se products (q é a propriedade computada) for menor que last_page isso é, se a pagina tal for menor que a página conseguinte então ela será apresentada
			<li v-if="products.current_page < products.last_page">-->
				<!--pego a página atual mais 1
				<a href="#" @click.prevent="loadProducts(products.current_page + 1)">
					Próximo
				</a>
			</li>
		</ul>-->
	</div>
</template>

<script>
	//importando o formulário
	import ProductForm from './partials/ProductForm'
	//importando o modal
	import Vodal from 'vodal'
	//importando o component para paginação
	import PaginationComponent from '../../../layouts/PaginationComponent'
	//chamando o component de pesquisa em admin/layouts/SeachComponent
	import SearchComponent from '../../layouts/SearchComponent'
	//vuex vai controllar todos os estados dos produtos
	//crio em vuex/modules/produtos
	export default {
		created () {
			//chamo o método 
			//this.loadProducts()
			//incluio um valor padrão 1 que significa primeira página
			this.loadProducts(1)
		},
		data ()  {
			return {
				//crio a propriedade vazia
				search: '',
				showModal: false,
				//pra cadastrar eu recebo esses valores fazios mas para editar eu recebo o response lá no método edit()
				//propriedade para edit com os valores default
				//e passo esse product para o formuláio lá no @success=""><
				product: {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				},
				update: false,
			}
		},
		//crio uma propriedade computada
		computed: {
			products () {
				//vai retornar o store, o state e products q é o modulo e itmes que tem os itens
				//tendo isso já posso lista-los
				return this.$store.state.products.items
			},
			params () {
				//aqui retorno os valores que vou enviar para a api
				return {
					//page: 1 em network pode se observar que consta esse dado
					//pego lá o dado current_page
					//posso passar apenas page mas  pensando lá na frente posso obter filtros mais completos
					page: this.products.current_page,
					//os parâmetros são enviados então vou enviar por ele o search que é recebido pelo filter
					filter: this.search

				}
			}
		},
		methods: {
			//loadProducts () {
			//incluindo dados para a paginação
			//coloco um valor page
			loadProducts (page) {
				//esse método dispara a action
				//esse é o nome da action: loadProducts
				//em state.js vamos atualizar o estado
				//this.$store.dispatch('loadProducts')
				//incluindo um parâmetro para a paginação, só de incluí-lo consulta os produtos e já é passado para a propriedade comutada os itens da página 1
				this.$store.dispatch('loadProducts', {...this.params, page})

			},
			edit (id) {
				this.$store.dispatch('loadProduct', id)
								.then(response => {
									//o product da props que recebe os valores por default receberá da api os valores da response
									this.product = response
									//para mostar o modal passo ele para true pois seu valor default esta false
									this.showModal = true
									//passando o update para true para informar q vou atualizar
									this.update = true
								})
								.catch(() => {
									this.$snotify.error('Algo Errado', 'Erro')
								})
			},
			/*editar
			edit (id) {
				//crio uma action para fazê-lo
				this.$store.dispatch('loadProduct', id)
						.then(response => {
						//aqui pego o product que criei q é o data vai receber o response que é os dados que vem da api então aqui é o valor que quero editar
						this.product = response
						//e para mostar o modal eu o chamo e passo para true
						this.showModal = true
						//passo o update para true que infoma q quero autorizar atualizar 
						this.update = true 
						})
						.catch(() => {
							this.$snotify.error('Algo errado', 'Erro')
						})
						//se formos em ProductForm temos um props que é opcional que posso passar o produto em si
						//no data(){} vamos criar uma propriedade product aqwui
			},*/
			//método para pesquisa
			//tem como parâmetro o filter e enviariará esse parâmetro para a pesquisa
			//temos em nossa propriedade computada um parâmetro que retorna um objeto, para enviar tudo isso criamos o date () {...}
			searchForm (filter) {
				//pegamos a propriedade search lá do data(){...}
				this.search = filter

				//temos que chamar o método para carregar os novos dados
				//como parâmetro colocamos a pag. 01 para voltar a mesma
				this.loadProducts(1)

			},
			//metodo para fechar o modal
			hideModal () {
				this.showModal = false
			},
			//métdo para fechar o modal
			success () {
				//chamo o método que já está pronto
				this.hideModal()
				//atualizao
				this.loadProducts(1)
			}
		},
		components: {
			pagination: PaginationComponent,
			search: SearchComponent,
			//registro o modal
			Vodal,
			ProductForm,

		}
	}
</script>

<style scoped>
	
</style>
<template>
	<div>
		<h2>Listagem Categorias</h2>

		<!--botão para cadastrar e crio dentro desta mesma pasta o AddCategoriesCompo..-->
		<div class="row">
			<div class="col">
				<router-link :to="{name: 'admin.categories.create'}" class="btn btn-success">Cadastrar</router-link>
			</div>
			<div class="col">
				<!--escuto a ação lá do SearchCategoryComponent enviada pelo emit() e delego para algum método que no caso é o search

O que acontece? Quando clico em pesquisar dispera o evento chamado searchCategory passando o filter q é o valor q a é informado dispara no emit que é o @searchCategory, método search atualiza o valor q foi informado e chama novamente o loadCategory()
				-->
				<search @searchCategory="search"></search>
			</div>
		</div>

		<table class="table table-dark">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nome</th>
					<th width="200">Ações</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(category, index) in categories.data" :key="index">
					<td>{{ category.id }}</td>
					<td v-text="category.name"></td>
					<td >
						<router-link :to="{name: 'admin.categories.edit', params: {id: category.id}}" class="btn btn-success">Editar</router-link>

						<a href="#" class="btn btn-danger" @click.prevent="confirmDestroy(category)">Remover</a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
//como vou buscar esses dados via ajax vamos usar o axios
import axios from 'axios'

//importando SearchCategoryComponent
import SearchCategoryComponent from './partials/SearchCategoryComponent'



export default {
	created () {
		//retiro esse método this.loadCategories()
		//vou chamar o action do categories.js
		//chamo o objeto store do store.js que se comunica com a categories.js e o método dispatch traz o método de categories.js que faz a action(a ação)
		//buscou nossa api
		//
		this.loadCategories()

	},
	data () {
		return {
			//criado um propriedade filter vazia por padrão
			name: '',
			//quem faz o carregamento das categorias é a nossa actio reloadCategories, por padrão ele não recebe nenhum parâmetro, mas vamos mudar isso agora
			//no ComponentCategorie f12 network temos o elemento (categorie?name=) vazio pq aqui assim está
		}
	},
	//uso o computed para listar os itens
	computed: {
		categories () {
			//retorna o objeto de store.js que busca o estado: state de categories.js onde tem os items dentro da state 
			//return this.$store.state.categories.items

			//chamo o loadCategories para carregar os novos dados da página
			return this.$store.state.categories.items
		}
	},
	//indo no adminCompo
	/*não preciso mais usá-los
	data () {
		return {
			categories: {
				data: []
			},
		}
	},
	*/

	//fazer o carregamento dos dados
	//método q vai carregar os dados, vai conectar com a api e ela vai devolver esses dados
	methods: {
		/*Mudo a lógica  levo tudo para o action: {}
		loadCategories () {
			//coloco a url q vou utilizar q é a api/ a versão /v1 e o recurso /categories para no momento não dar erro removo o filtro de autenticação em api
			//acesso os recursos de cateories usando a requisição tipo get
			//axios.get('/api/v1/categories')
			//axios.get('http://localhost:3000/')
			axios.get('/api/v1/categories')
			//responde é o retorno q vamos tratar tipo log
				 .then(response => {
				 	console.log(response)

				 	this.categories = response
				 })
				 .catch(errors => {
				 	console.log(errors)
				 })
		}*/
		/*loadCategories para atualizar a página
		loadCategories () {
			this.$store.dispatch('loadCategories')
		},*/
		//quem faz o carregamento das categorias é a nossa actio reloadCategories, por padrão ele não recebe nenhum parâmetro, mas vamos mudar isso agora
		//vou em categories.js e modifico a action 
		loadCategories () {
			this.$store.dispatch('loadCategories', {name: this.name})
		},
		confirmDestroy (category) {
			this.$snotify.error(`Deseja realmente deletar a categoria: ${category.name}`, 'Deletar?', {
				//o tempo
				timout: 10000,
				//mostra a barra de progresso
				showProgressBar: true,
				//fecha a janela
				closeOnClick: true,
				buttons: [
				{text: 'Não', action: () => console.log('Não deletou...')},
				{text: 'Sim', action: () => this.destroy(category)}
				]
			})
		},
		destroy(category) {
			//chamo o nosso vuex,chamo uma action destroyCategory e passo para o nosso item o id da categoria q qero deletar
			this.$store.dispatch('destroyCategory', category.id)
			//se der certo
						.then(() => {
							this.$snotify.success(`Sucesso ao deletar a categoria: ${category.name}`)

							this.loadCategories()
						})
						//em caso de falha
						.catch(error => {
							this.$snotify.error('Erro ao deletar a categoria', 'Falha')
						})
		},
		//ele recebe como parâmetro o próprio item que é o filter lá do SearchCategoryComponent do método search
		search (filter) {
			//pego a propriedade name daqui do data () { name: ''} e atualizo ela com o filter que é colocado no input da pesquisa
			this.name = filter

			//e pra carregar a lista atualiza com a pesquisa chamo loadCategories
			this.loadCategories()

		}
	},
	//chamando o formulário search
	components: {
		search: SearchCategoryComponent
	}
}
</script>
<template>
	<div>
		<h2>Listagem Categorias</h2>

		<!--botão para cadastrar e crio dentro desta mesma pasta o AddCategoriesCompo..-->
		<router-link :to="{name: 'admin.categories.create'}" class="btn btn-success">Cadastrar</router-link>

		<table class="table table-dark">
			<thead>
				<tr>
					<th>Id</th>
					<th>Nome</th>
					<th width="100">Ações</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(category, index) in categories.data" :key="index">
					<td>{{ category.id }}</td>
					<td v-text="category.name"></td>
					<td >
						<router-link :to="{name: 'admin.categories.edit', params: {id: category.id}}" class="btn btn-success">Editar</router-link>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
import axios from 'axios'
//como vou buscar esses dados via ajax vamos usar o axios

export default {
	created () {
		//retiro esse método this.loadCategories()
		//vou chamar o action do categories.js
		//chamo o objeto store do store.js que se comunica com a categories.js e o método dispatch traz o método de categories.js que faz a action(a ação)
		//buscou nossa api
		this.$store.dispatch('loadCategories')

	},
	//uso o computed para listar os itens
	computed: {
		categories () {
			//retorna o objeto de store.js que busca o estado: state de categories.js onde tem os items dentro da state 
			return this.$store.state.categories.items
		}
	}
	//indo no adminCompo
	/*não preciso mais usá-los
	data () {
		return {
			categories: {
				data: []
			},
		}
	},
	

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
		}
	}*/
}
</script>
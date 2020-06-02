//importo o Vue para as rotas
import Vue from 'vue'
//implemento VueRouter
import VueRouter from 'vue-router'

//modificando o prefixo e organizando por subrotas
import AdminComponent from '../components/admin/AdminComponent'

//importando o component
import CategoriesComponent from '../components/admin/pages/categories/CategoriesComponent'
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent'
import AddCategoryComponent from '../components/admin/pages/categories/AddCategoryComponent'
import EditCategoryComponent from '../components/admin/pages/categories/EditCategoryComponent'

Vue.use(VueRouter)

/*vamos organizar as rotas em subrotas agora:
//crio constante q terá todas as rotas do nosso projeto
const routes = [
//faço a definição da rota do CategoriesComponent
	{path: '/categories', component: CategoriesComponent, name: 'admin.categories'},
	{path: '/', component: DashboardComponent, name: 'admin.dashboard'}

]
*/
const routes = [
//faço a definição da rota do CategoriesComponent
	//nosso prefixo será admin, vou utilizar o AdminComponent.vue para rotear os arquivos de administração
	{
		path: '/admin',
		component: AdminComponent,
		//children são as rotas filhas q virão em array
		children: [
			//retiro / barra dos path
			//{path: '/', component: DashboardComponent, name: 'admin.dashboard'}
			//vou no AdminComponent.vue e faço ele cuidar das rotas passando o <router-view><rout... deleto o App.vue pois adminCompenet fica no lugar
			{path: '', component: DashboardComponent, name: 'admin.dashboard'},
			{path: 'categories', component: CategoriesComponent, name: 'admin.categories'},
			{path: 'categories/create', component: AddCategoryComponent, name: 'admin.categories.create'},
			{path: 'categories/:id/edit', component: EditCategoryComponent, name: 'admin.categories.edit', props: true},
			//vou com categoriesComponent e crio o router-link
		]
	},
]
//exporto o objeto de rota que é a constante router
const router = new VueRouter({
//aqui a constante routes que tem armazenado as rotas
	routes
})
//e aqui é a variável
export default router
//e incluo no noso arquivo js
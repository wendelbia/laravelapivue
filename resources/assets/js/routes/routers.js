//importo o Vue para as rotas
import Vue from 'vue'
//implemento VueRouter
import VueRouter from 'vue-router'

//acesso ao vuex para saber se estou autenticado para usar metas
import store from '../vuex/store'

//modificando o prefixo e organizando por subrotas
import AdminComponent from '../components/admin/AdminComponent'

//importando o component
import CategoriesComponent from '../components/admin/pages/categories/CategoriesComponent'
import DashboardComponent from '../components/admin/pages/dashboard/DashboardComponent'
import AddCategoryComponent from '../components/admin/pages/categories/AddCategoryComponent'
import EditCategoryComponent from '../components/admin/pages/categories/EditCategoryComponent'
import ProductsComponent from '../components/admin/pages/products/ProductsComponent'
import ProductsReports from '../components/admin/pages/reports/ProductsReports'
import HomeComponent from '../components/frontend/pages/home/HomeComponent'
import SiteComponent from '../components/frontend/SiteComponent'
import ContactComponent from '../components/frontend/pages/contact/ContactComponent'
import ProductDetail from '../components/frontend/pages/product/ProductDetail'
import CartComponent from '../components/frontend/pages/cart/CartComponent'
import LoginComponent from '../components/frontend/pages/login/LoginComponent'
import RegisterComponent from '../components/frontend/pages/user/RegisterComponent'
import ProfileComponent from '../components/frontend/pages/user/ProfileComponent'


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

	//criando uma configuração para home do webservice
	{path: '/', 
		component: SiteComponent,
		//todos os outros components filhos(children) passam pelo SiteComponent assim como foi no '/admin', passo o array e passo os components de dependem dele
		children: [
		//na page login sendo acessada após já ter sido logado, podemos aplicar melhorias pois não faz sentido acessá-la já estando logado então podemos colocar os dados do usu logado
			//{path:'login', component: LoginComponent, name: 'login'},
			{path:'login', component: LoginComponent, name: 'login', meta: {auth: false}},
			//na página de register ficará aqui mantido o auth:false para caso o já logado tentar acessar, será redirecionado para a página inicial
			{path:'cadastrar', component: RegisterComponent, name: 'register', meta: {auth: false}},
			{path:'meu-perfil', component: ProfileComponent, name: 'profile', meta: {auth: true}},
			{path:'carrinho', component: CartComponent, name: 'cart'},
			{path: '', component: HomeComponent, name: 'home'},
			//rota para mostar detales do produto, passo props igual a true então consigo pegar o id do produto
			{path: 'produto/:id', component: ProductDetail, name: 'product.detail', props: true},
			{path: 'contato', component: ContactComponent, name: 'contact'}
			
		]
	},
	{
		path: '/admin',
		component: AdminComponent,
		//para não aplicar nossa meta em cada rota crio um grupo, posso inserir como segundo parâmtro apenas adminstradores:",admin:true", esse tipo de restrição de conteúdo é feito no backend e não aqui
		meta: {auth: true},
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

			//rotas de products
			{path: 'products', component: ProductsComponent, name: 'admin.products', meta: {auth: true}},
			{path: 'products-reports', component: ProductsReports, name: 'products.reports'}
		]
	},
]
//exporto o objeto de rota que é a constante router
const router = new VueRouter({
//aqui a constante routes que tem armazenado as rotas
	routes
})

//para o acesso entre as páginas liberando apenas para usuários authenticados uso o beforeEach()
router.beforeEach((to, from, next) => {
	//é passado uma propriedade chamada meta na qual é possível restringir pessoas com tais informação que podem ser restringidas ou liberadas o acesso, por exemplo : pegar apenas pessoas autenticadas e adminstradoras, se eu não qero que acesse pessoa não autenticadas acesse a pág. de produtos então no path eu passo: ...name:'admin/products', meta: {auth:true}
	//console.log(to)
	//se a rota precisa de autenticação e essa pessoa não estiver logada, entaõ e redirecionada para a rota de login, mas preciso saber se o usuário está logado ou não, lá no vue dev tools em authenticated está como true, como faço para ter acesso a ele para conferir:importo o vuex e busco essa infomação
	//ele retorno true se logado e false se não, coloco a negação para obter a lógica
	if (to.meta.auth && !store.state.auth.authenticated) {
		//armazeno a url q o usu estava antes de ser redirecionado, então peago o mutation e o nome da url, estamos trabalhando com name, nossas rotas tem name, se fosse direto usariamos to.path e o nome da página então assim seria, por exemplo dashboar...barra painel etc...
		store.commit('CHANGE_URL_BACK', to.name)

		//retorno o objeto e uso o push para redirecionar
		return router.push({name: 'login'})
		//só essa lógica não vai funcionar por que o auth está pegando apenas no component pai, nas outras não funcionará, para isso
	}
	//para verificar se exite a propriedade meta na rota admin por exemplo eu aplico essa lógica, se uso em outra url que não tenha a meta então dara false
	//console.log(to.matched.some(record => record.meta.auth))

	//se a rota pai precisa de autenticação e (&&) não estã autenticada
	if (to.matched.some(record => record.meta.auth) && !store.state.auth.authenticated) {
		store.commit('CHANGE_URL_BACK', to.name)
		//mando o user para fazer o login
		return router.push({name: 'login'})
		//com isso agora toda as nossas rotas passam pelo nosso filtro admin pois uso no path: meta: {auth: true},
	}
	//verifico se a propriedade auth existe na propriedade meta, para isso uso um método do js o hasOwnerProperty('auth') para verificar se existe a propriedade auth no meta se o auth for false redireciono o usu para dashboard ou seja se não precisar de autenticação na rota e o usu já estiver autenticado, redireciono para o dashboard, então verifico esses 3 lógicas, se auth está em meta se auth não existe e se auth está autenticado
	if (to.meta.hasOwnProperty('auth') && !to.meta.auth && store.state.auth.authenticated) {
		return router.push({name: 'admin.dashboard'})//vou para SiteHeaderComponent.vue
	}
	//caso contrário continua
	next()
})

//e aqui é a variável
export default router
//e incluo no noso arquivo js
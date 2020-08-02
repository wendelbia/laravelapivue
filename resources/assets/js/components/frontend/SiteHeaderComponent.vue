<template>
	<div>
		<ul class="nav">
			<li class="nav-item">
				<router-link :to="{name: 'home'}" class="nav-link">HOME</router-link>
			</li>

			<li class="nav-item">
				<router-link :to="{name: 'contact'}" class="nav-link">CONTATO</router-link>
			</li>

			<li class="nav-item">
				<router-link :to="{name: 'cart'}" class="nav-link">CARRINHO ({{ cart.length }})</router-link>
			</li>
			<!--se o usu estiver logado
			<li class="nav-item" v-if="me.name">
				<router-link :to="{name: 'admin.dashboard'}" class="nav-link">-->
			<!---logout para a saíde de usu
				Olá {{ me.name }}! (<a @click.prevent="logout">Sair</a>)</router-link>
			</li>-->

			<li class="nav-item dropdown show" v-if="me.name">
				<a class="dropdown-toggle nav-link" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Olá {{ me.name }}!
				</a>

				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" >
					<router-link :to="{name: 'profile'}" class="nav-link">Menu Perfil
					</router-link>
					<!--
					<a href="" class="dropdown-item">Menu Perfil</a>
					-->
					<a class="dropdown-item" @click.prevent="logout">Sair</a>
				</div>
			</li>
			<li class="nav-item" v-else>
				<router-link :to="{name: 'login'}" class="nav-link">LOGIN</router-link>
			</li>
		</ul>
	</div>
</template>

<script>
export default {
	//crio um propriedade computada
	computed: {
		cart () {
			return this.$store.state.cart.products
		},
		//melhorias para o redirecionamento quando usu já estiver logado e clicar em login
		me () {
			//busco o store o estado o usu logado e o usu
			return this.$store.state.auth.me
		}
	},

	methods: {
		logout () {
			//vou chamar um mutation para mudar diretamente lá na auth.js
			this.$store.dispatch('logout')
		}
	}
}
</script>
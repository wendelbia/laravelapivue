<!--ficará o template de admin-->
<template>
	<div>
		<!--para que não aparece duplicado vou em welcome e troco por <router-view> o -->
		<ul class="nav bg-dark">
			<li class="nav-item">
				<router-link :to="{name: 'admin.dashboard'}" class="nav-link">Dashboard</router-link>
			</li>
			<li>
				<!--já q nossos components estão relacionados uns com os outros por causa do vuex posso usar nossas categoias estão centralizadas em um único estado posso usar uma propriedade computada chamada total-->
				<router-link :to="{name: 'admin.categories'}" class="nav-link">Categorias ({{totalCategories}})</router-link>
			</li>
			<li>
				<router-link :to="{name: 'admin.products'}" class="nav-link">Produtos</router-link>
			</li>
		</ul>
		<!--Sou o template de admin-->
		<!--usando o <router-view> para rotear as admin's -->
		<!--agora implemento a parte de categoria vou em pages-->
		<div class="container">
			<router-view></router-view>
			<!--vou em categoriesComponent e coloco um título para saber que página estou -->
		</div>
		
	</div>
</template>

<script>
	export default {
		computed: {
			totalCategories () {
				//objeto store busca em state de categories.js o estado categories onde dentro dele temos items e pego a data em si que tem os dados e quantifico
				return this.$store.state.categories.items.data.length
			}
		}
	}
</script>

<style>
	
</style>
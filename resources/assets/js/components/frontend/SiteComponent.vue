<template>
	<!--vamos definir aqui o nosso menu para nossa homepage-->
	<div>
		<header-site></header-site>

		<router-view></router-view>
		<!--para não sobrecarregar o SiteCompenent podemos cria uma par o footer-->
		<footer-site></footer-site>
	</div>
</template>

<script>
import SiteFooterComponent from './SiteFooterComponent'

import SiteHeaderComponent from './SiteHeaderComponent'

export default {
	components: {
		footerSite: SiteFooterComponent,		
		headerSite: SiteHeaderComponent,
	}
}
</script>
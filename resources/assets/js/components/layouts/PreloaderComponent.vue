<!--para usar o nosso component de forma mais global eu registro em app.js-->
<template>
	<!-- se o preloader for igual a true show(mostra)-->
	<div class="preloader" v-show="preloader">
		<!-- podemos formatar o gif no browser/f12/elements clico na  imagem aparece o código-->
		<img src="/imgs/preloader4.gif" alt="Preloader...">
	</div>
</template>

<script>
	export default {
		//recuperar o nosso item através do computed
		computed: {
			//crio um método para retornar aquele state do preloader
			preloader () {
				return this.$store.state.preloader.loading //faço um if para true
			}
		}
	}
</script>

<style scoped>
/*
.preloader {
    background: #000;
    position: absolute;
    z-index: 9999;
    opacity: .2;
    width: 100%;
    height: auto;
    margin: 0;
    text-align: center;
    padding: 5% 0;
}	
.preloader img{
	max-width: 100px;
}*/
.preloader {
	
	position: absolute;
	width: 100%;
	z-index: 9999;
	height: 90%;
	margin: 0;
	text-align: center;
	padding: 5% 0;
}
.preloader img{
	max-width: 500px;
	background-attachment: fixed;
}

</style>
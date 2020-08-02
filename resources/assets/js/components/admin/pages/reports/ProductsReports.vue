<template>
	<div>
		<h1>Relatório de Produtos</h1>
		<hr>
		<!--filtro de relatório os options serão os anos, para isso criamos um propriedade computada-->
		<select class="form-control" v-model="year" @change="charts">
			<option :value="i" v-for="i in years" :key="i">
				{{ i }}
			</option>
		</select>
		<!--chamo as props-->
		<line-chart
		:labels="labels"
		:datasets="datasets">
		</line-chart>
	</div>

</template>

<script>
import LineChart from './charts/LineChart'

export default {
	components: {
		LineChart
	},
	computed: {
		//propriedade computada para filtro de relatório do ano
		years () {
			//objeto ano vai trazer ano atual em forma de 4 digitos
			let year = new Date().getFullYear()
			//objeto startYear vai receber o ano atual -10, traz os 10 para atrais
			let startYear = year - 10
			let years = []
			let j = 0
			for (let i = year; i >= startYear; i--) {
				years[j] = i 
				//years.push(i)
				j++
			}
			return years
		}
	},
	mounted () {
		this.charts()
	},
	data () {
		return {
			year: new Date().getFullYear(),
			labels: [],
			datasets: [
				{
					label: 'mês',
					backgroundColor: 'transparent',
					borderColor: '#000',
					data: []
				}
			]
		}
	},
	methods: {
		charts () {
			//faremos nossa chamada ajax, que tem como params o years para filtrar o ano, incluindo código no ReportController
		this.$store.dispatch('reportsProducts', {year: this.year})
		//recupero o then que é o retorno
						.then(response => {
							this.labels = response.data.labels
							this.datasets[0].data = response.data.datasets
						})
						.catch(() => {
							this.$snotify.error('Erro ao atualizar os gráficos')
						})
		}
	}
}

</script>

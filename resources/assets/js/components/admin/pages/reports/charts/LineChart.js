import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  //uma props para passar o labels e o datasets
  //props: ['labels', 'datasets'],
  //posso também especificar
  props: {
    labels: {
      require:true,
      type: Array
    },
    datasets: {
      require: true,
      type: Array
    }
  },
  mounted () {
    /* coloco tudo isso dentro do método para que seja usado
    this.renderChart({
    
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      
      datasets: [
        {

          label: 'Data One',
          backgroundColor: '#f87979',
          //podemos modificar: backgroundColor: 'tranparent',
          //borderColor: '#000'
          data: [40, 39, 10, 40, 39, 80, 40]
        }*/
        /*podemos comporar um valor com o outro
         {
          label: 'Data One',
          backgroundColor: '#f87979',
          //podemos modificar: backgroundColor: 'tranparent',
          //borderColor: '#000'
          data: [40, 39, 10, 40, 39, 80, 40]
        },
         {
          label: 'Data Two',
          backgroundColor: 'tranparent',
          
          borderColor: '#999',
          data: [90, 9, 100, 46, 9, 0, 4]
        }
      ]apresento o labels e datasets de outra maneira
      labels: this.labels,
      datasets: this.datasets,
    }, {responsive: true, maintainAspectRatio: false})*/
    this.charts()
  },
  //crio um methods para não duplicar código
  methods: {
    charts () {
      this.renderChart({
        labels: this.labels,
        datasets: this.datasets,
      }, {responsive: true, maintainAspectRatio: false})  
    }
  },
  //crio um watch para ficar escutando essas propriedades pois em ProductsReport a comunicação com vuex é antes das propriedades serem chamadas através do data:{}...
  watch: {
    labels () {
      this.charts()
    }
  }
}
<script type="text/javascript">
  import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  data: () => ({
    chartdata: {
      labels: ['Active','Invited','Trash'],
      datasets: [
        {
          label: 'Project created by month',
          backgroundColor: '#12344D',
          data: [4,3,2],
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
  }),

  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>
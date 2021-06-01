<script type="text/javascript">
  import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  data: () => ({
    chartdata: {
      labels: ['Active','Invited','Trash'],
      datasets: [
        {
          label: 'Your Projects',
          backgroundColor: ['#12344D','#2ab27b','#FFA800'],
          data: [4,1,2]
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),

  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>
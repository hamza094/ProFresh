<script>
  import { Bar } from 'vue-chartjs'
  
  export default {
    extends: Bar,
    data() {
      return {
        chartData: {
          labels: [],
          datasets: [
            {
              label: ['Active Projects'],
              backgroundColor: 'purple', 
              data: []
            },
             {
              label: ['Trashed Projects'],
              backgroundColor: 'yellow', 
              data: []
            },
             {
              label: ['Member Projects'],
              backgroundColor: 'orange', 
              data: []
            },
          ]
        },
        totalProjects: 0,
        totalTasks: 0,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            xAxes: [{ stacked: false }],
            yAxes: [{ 
              stacked: false,
              ticks:{
                beginAtZero: true,
              }
           }]
          }
        }
      };
    },
    methods: {
      async fetchData() {
        try {
          const response = await axios.get('/api/v1/data');
          const data = response.data.projectsData;

          this.chartData.labels = ['Total Projects: '+data.total_projects];
          
          this.chartData.datasets[0].data = [data.active_projects];

          this.chartData.datasets[1].data = [data.trashed_projects];
          
          this.chartData.datasets[2].data = [data.active_invited_projects];
                  
        this.renderChart(this.chartData, this.options);
        } catch (error) {
          console.error('Error fetching data:', error);
        }
      },
    },
    mounted() {
      this.fetchData();
    }
  };
</script>
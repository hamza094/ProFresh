<template>
	<div>
     <div class="page-top">Welcome To Your Dashboard</div>
     	<div class="dashboard-project m-4">
     		<p class="dashboard-heading float-left"><b>Recent Active Projects</b></p>
     			<span class="float-right">
     			<router-link to="/projects" class="btn btn-sm btn-primary">
     				<i class="fas fa-list"></i> View All Projects
     			</router-link>
             	</span>
     	</div>
        <br><br>
     	<div class="dashboard">
     		<div class="row">
				<div v-if="message" class="m-3">
				<h5>
				<b>{{message}}</b>
			    </h5>
				</div>

     			<div class="col-md-4" v-for="project in projects" :key="project.id">
					<router-link :to="'/projects/'+project.slug" class="dashboard-link">
     			<div class="dashboard-projects mt-5 active-projects">
                    <div class="project-status">
					<b>Active</b>
					</div>
                    <div class="project-title">{{project.name}}</div>
                    <div class="project-info">
                        <div class="info-item">
                            <span class="info-label">Stage:</span>
                            <span class="info-value">{{ project.stage.name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status:</span>
                            <span class="info-value">{{project.status}}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Created:</span>
                            <span class="info-value">{{project.created_at}}</span>
                        </div>
                    </div>
     		</div>
                </router-link>
     			</div>
     			
     		</div>
     	</div>
        <div class="dashboard-project_info m-5">
        <p class="float-left"><b>Your Projects Info</b></p>
        <br>
        <div class="row">
            <div class="col-md-6">
            <ProjectChart> </ProjectChart>
            </div>
            <div class="col-md-6">
            <p><b>Your Activity Calender</b></p>
            <div class="m-5">
                <vc-calendar 
                is-expanded
                :attributes='attributes'
                  />   
            </div>
            </div>
        </div>
        </div>
          <div class="dashboard-tasks_info m-5">
        <p class="float-left"><b>Your Tasks Info</b></p>
        <br>
        <div class="row">
            <TasksData></TasksData>
            <div class="col-md-5">
            <p><b>Your Tasks edith</b></p>
            <div class="m-5">
               
            </div>
            </div>
        </div>
        </div>
	</div>
</template>
<script>
    import ProjectChart from './ProjectChart.vue'
    import TasksData from './TasksData.vue'

export default{
    components: {ProjectChart,TasksData},

    data(){
    return{
	    projects: [],
        projectsCount: 0,
        message: '',
        activities:[],		
    };
    },
    computed: {
     attributes() {
      return [
        ...this.activities.map(activity => ({

          dates: moment(activity.time).format('YYYY-MM-DD'),
          dot: {
            color: activity.color,
            //class: todo.isComplete ? 'opacity-75' : '',
          },
          popover: {
            label: activity.description,
            visibility: 'hover',
          },
          customData: activity,
        })),
      ];
    },
  },
    methods:{
      calendarData(){
        axios.get('/api/v1/user/activities').
         then(response=>{
            this.activities=response.data;
         }).catch(error=>{
           console.log(error);
         });
      },  
      loadDashboardProjects(){
        axios.get('/api/v1/user/dashboard-projects').
            then(({data})=>(this.getData(data)));
      },
			getData(data){
				this.projects = data.projects;
				this.projectsCount = data.projectsCount;
				this.message = data.message;
			},
    },
    mounted(){
        this.loadDashboardProjects();
        this.calendarData();
    }
}
</script>

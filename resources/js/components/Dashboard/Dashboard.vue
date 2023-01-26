<template>
	<div>
     <div class="page-top">Welcome To Your Dashboard</div>
     	<div class="dashboard-project m-4">
     		<p class="dashboard-heading float-left"><b>Total
                <span>{{projectState}} Projects:</span>
								{{projectsCount}}
            </b></p>
     			<span class="float-right">

     			<button class="btn btn-sm btn-primary" @click.prevent="activeProjects">Active Projects</button>

     			<button class="btn btn-sm btn-success" @click.prevent="memberProjects">Projects Member</button>

                <button class="btn btn-sm btn-danger" @click.prevent="abandonedProjects">Abandoned Projects</button>
             	</span>
     	</div>
        <br><br>
     	<div class="dashboard">
     		<div class="row">
				<div v-if="message" class="m-3">
				<h5>
				<b>{{message}} in {{projectState}} Projects</b>
			    </h5>
				</div>

     			<div class="col-md-4" v-for="project in projects">
					<router-link :to="'/projects/'+project.slug" class="dashboard-link">
     			<div class="dashboard-projects mt-5">
                    <span class="float-right">
					<b>{{projectState}}</b>
					</span>
     			<p class="mt-3">{{project.name}}</p>
     			<p>Project Stage: <span v-text="stage(project)">
     			</span></p>
     			<p>Project Status:
				    <span> {{project.status}}</span>
				</p>
				<p>Created At: {{project.created_at}}</p>
     		</div>
                </router-link>
     			</div>
     			
     		</div>
     	</div>
        <div class="dashboard-project_info m-4">
        <p class="float-left"><b>Your Projects Info</b></p>
        <br>
        <div class="row">
            <div class="col-md-6">
            <ProjectChart> </ProjectChart>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        </div>
	</div>
</template>
<script>
    import ProjectChart from './ProjectChart.vue'

export default{
        components: {ProjectChart},

    data(){
    return{
	    projects: {},
        projectState: "",
        projectsCount: 0,
        message: '',		
    };
    },
    methods:{
      activeProjects(){
        axios.get(this.url()).
            then(({data})=>(this.getData(data)));
            this.projectState = "Active";
      },
      memberProjects(){
        axios.get(this.url()+'?member=true').
            then(({data})=>(this.getData(data)));
	        this.projectState = "Member";
      },
      abandonedProjects(){
         axios.get(this.url()+'?abandoned=true').
            then(({data})=>(this.getData(data)));
			this.projectState="Abandoned";
      },
			url(){
				return '/api/v1/user/projects';
			},
			getData(data){
				this.projects=data.projects,
				this.projectsCount=data.projectsCount,
				this.message=data.message;
			},
			 stage(project){
			   return this.currentStage(project.stage,project.completed);
			},
    },
    mounted(){
        this.activeProjects();
    }
}
</script>

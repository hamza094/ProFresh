<template>
	<div>
     <div class="page-top">Welcome To Your Dashboard</div>
     	<div class="dashboard-project m-4">
     		<p class="dashboard-heading float-left"><b>Total
                <span>{{projectState}} Projects:</span>
								{{projectsCount}}
            </b></p>
     			<span class="float-right">
     			<button class="btn btn-sm btn-primary" @click.prevent="actived">Active Projects</button>
     			<button class="btn btn-sm btn-success" @click.prevent="invited">Invited Projects</button>
                <button class="btn btn-sm btn-danger" @click.prevent="abandoned">Abandoned Projects</button>
             	</span>
     	</div>
        <br><br>
     	<div class="dashboard">
     		<div class="row">
					<div v-if="message" class="m-3">
					<h5><b>{{message}} in {{projectState}} Projects</b></h5>
					</div>
     			<div class="col-md-4" v-for="project in projects">
						  <router-link :to="'/project/'+project.slug" class="dashboard-link">
     				<div class="dashboard-projects mt-5">
                        <span class="float-right">
													<b>{{projectState}}</b>
												</span>
     					<p class="mt-3">{{project.name}}</p>
     					    <p>Project Satge:
                        <span>{{project.stage}} Stage</span>
                     </p>
     					<p>Project Score:
								<span v-if="project.score > 0">{{project.score}}</span>
								<span v-else>No project activity detected project currently scored zero</span>

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
    import ProjectChart from './ProjectChart'

export default{
        components: {ProjectChart},

    data(){
    return{
      projects:{},
      active:false,
      invite:false,
      abandon:false,
			projectState:"",
      projectsCount:0,
			message:''
    };
    },
    methods:{
      actived(){
        axios.get(this.url()).
            then(({data})=>(this.getData(data)));
          this.activeState();
      },
      invited(){
        axios.get(this.url()+'?invited=true').
            then(({data})=>(this.getData(data)));
						this.invitedState();
      },
      abandoned(){
         axios.get(this.url()+'?abandoned=true').
            then(({data})=>(this.getData(data)));
						this.abandonedState();
      },
			url(){
				return '/api/v1/userprojects';
			},
			getData(data){
				this.projects=data.projects,
				this.projectsCount=data.projectsCount,
				this.message=data.message;
			},
			activeState(){
				this.projectState="Active";
				this.invite=false;
				this.abandon=false;
				this.active=true;
			},
			invitedState(){
				this.projectState="Invited";
				this.active=false;
				this.abandon=false;
				this.invite=true;
			},
			abandonedState(){
				this.projectState="Abandoned";
				this.active=false;
				this.invite=false;
				this.abandon=true;
			}
    },
    mounted(){
        this.actived();
    }
}
</script>

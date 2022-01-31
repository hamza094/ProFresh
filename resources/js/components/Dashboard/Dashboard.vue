<template>
	<div>
     <div class="page-top">Welcome To Your Dashboard</div>
     	<div class="dashboard-project m-4">
     		<p class="dashboard-heading float-left"><b>Projects:
                <span v-if="this.active">Active Projects</span>
                <span v-else-if="this.invite">Invited Projects</span>
                <span v-else="this.trash">Trashed Projects</span>
            </b></p>
     			<span class="float-right">
     			<button class="btn btn-sm btn-primary" @click.prevent="actived">Active Projects</button>
     			<button class="btn btn-sm btn-success" @click.prevent="invited">Invited Projects</button>
                <button class="btn btn-sm btn-warning" @click.prevent="trashed">Trashed Projects</button>
             	</span>
     	</div>
        <br><br>
     	<div class="dashboard">
     		<div class="row">
     			<div class="col-md-3" v-for="project in projects">
						  <router-link :to="'/project/'+project.slug" class="dashboard-link">
     				<div class="dashboard-projects mt-5">
                        <span class="float-right"><b>Active</b></span>
     					<p class="mt-3">{{project.name}}</p>
     					    <p>Project Satge:
                        <span>{{project.stage}} Stage</span>
                     </p>
     					<p>Project Score: {{project.score}}</p>
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
      trash:false,
      projectActive:0,
    };
    },
    methods:{
      actived(){
        axios.get('/api/v1/userprojects').
            then(({data})=>(this.projects=data.projects));
            this.active=true;
            this.invite=false;
            this.trash=false;
      },
      invited(){
        axios.get('/api/v1/userprojects?invited=true').
            then(({data})=>(this.projects=data.projects));
            this.active=false;
            this.invite=true;
            this.trash=false;
      },
      trashed(){
         axios.get('/api/v1/userprojects?trashed=true').
            then(({data})=>(this.projects=data.projects));
            this.active=false;
            this.invite=false;
            this.trash=true;
      },
    },
    created(){
        this.actived();
    }

}
</script>

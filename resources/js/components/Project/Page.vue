<template>
	<div>
		<div class="container-fluid ">
				<div class="row">
						<div class="col-md-8 page pd-r">
								<div class="page-top">
										<div>
						<span>
								<span class="page-top_heading">Projects </span>
								<span class="page-top_arrow"> > </span>
								<span> {{project.name}}</span>
						</span>
						<span class="float-right">Project features with button</span>
										</div>
								</div>
								<div class="page-content">
										<div class="row">
												<div class="col-md-2">
	                     <Status :projectName='project.name' :start="project.created_at"
											    :stage="project.stage"
												:completed="this.project.completed" :status="project.status">
											</Status>
												</div>
												<div class="col-md-10">
													<div class="content">
													<p class="content-name">
														<span v-if="nameEdit"> <input class="form-control sm-6" type="text" name="name" v-model="projectname"></span>
														<span v-else>{{project.name}}</span>
													<span v-if="nameEdit">
														<button type="button" class="btn btn-link btn-sm" @click="updateName()">Update</button>
														<button  type="button" class="btn btn-link btn-sm" @click="cancelUpdate()">Cancel</button>
														</span>
														<span v-else>
															<button v-if="accessAllowed" type="button" class="btn btn-link btn-sm" @click="nameEdit = true">Edit</button>
														</span>
														</p>
													<p class="content-info">
													 Created On
													 <span class="content-dot"></span>
															{{project.created_at}}
													 </p>
													<p class="content-info">
													Created By<span class="content-dot"></span>
														  		 <a target="_blank" :href="user.id" class="btn btn-link">{{user.name}}</a>
															</p>
												</div>
													</div>
									 </div>
										<hr>
										<p class="pro-info">Project Detail</p>
										<div class="row">
												<div class="col-md-6">
													  <p  class="crm-info"> <b>About</b>:
															<span v-if="aboutEdit">
															 <textarea name="name" rows="4" cols="30" v-model="projectabout" v-text="project.about" class="form-control"></textarea>
														 </span>
														 <span v-else> {{project.about}} </span>
															<span v-if="aboutEdit">
																<button type="button" class="btn btn-link btn-sm" @click="updateAbout()">Update</button>
																<button type="button" class="btn btn-link btn-sm" @click="aboutCancel()">Cancel</button>
															</span>
															<span v-else>
																<button v-if="accessAllowed" type="button" class="btn btn-link btn-sm" @click="editAbout()">Edit</button>
															</span>
														</p>
														<p v-if="!project.postponed" class="crm-info"> <b>Postponed reason</b>: <span> The project is currently active.
														 Please try to avoid the project being postpone without any reason </span></p>
														<p v-else class="crm-info"> <b>Postponed reason</b>: <span> {{project.postponed}}  </span></p>
												</div>
												<div class="col-md-6">
														<p class="crm-info"> <b>Tasks</b>: <span> Info </span></p>
														<p class="crm-info"> <b>Appointments</b>: <span> Info </span></p>
														<p class="crm-info"> <b>Other</b>: <span> Info </span></p>
										</div>
										</div>
										<br>
										<Stage :slug="project.slug" :projectstage='project.stage' :postponed="project.postponed"
										:completed="project.completed" :stage_updated="project.stage_updated_at" :get_stage="this.getStage" :access="this.accessAllowed">
									</Stage>
										<br>
										<hr>
										<h3>RECENT ACTIVITIES</h3>
										<div class="row">
									 <div class="col-md-7 mb-5">
										 <div class="activity">
											<span>project activity card</span>
										</div>
									 </div>

									 <div class="col-md-5">
										 <div class="project-info">
									 	   <div class="project-info_socre">
									 	    <p class="project-info_score-heading">Status</p>
									 	    <p class="project-info_score-point" :class="'project-info_score-point_'+project.status">0</p>
									 	  </div>
									 	  <div class="project-info_rec">
									 	    <span>Last Seen</span>
									 	    <!-- <p>{{Carbon\Carbon::parse($project->user->lastseen)->diffforHumans()}}</p>-->
									 	  </div>
									 	  <div class="project-info_rec">
									 	    <span>Stage Updated</span>
									 	     <p v-text="project.stage_updated_at"></p>
									 	  </div>
									 	  <div class="project-info_rec">
									 	    <span>Last modified</span>
									 	     <p v-text="project.updated_at"></p>
									 	  </div>
									 	</div>
									 </div>

										</div>
								</div>
						</div>
						<div class="col-md-4 side_panel">
               Project Side Panel
							<br>
							<Task :slug="project.slug" :tasks="project.tasks" :access="this.accessAllowed"></Task>
							<hr>
						<PanelFeatues :slug="project.slug" :notes="project.notes"
						:members="project.members" :owner="user" :access="this.accessAllowed" :ownerAccess="project.isOwner"></PanelFeatues>
						</div>
				</div>
		</div>
	</div>
</template>
<script>
	import Status from './Status'
	import Stage from './Stage'
	import Task from './Panel/Task'
	import PanelFeatues from './Panel/Features'

export default{
	  components:{Status,Stage,Task,PanelFeatues},
    data(){
    return{
     project:[],
		 user:{},
		 getStage:0,
		 nameEdit:false,
		 projectname:"",
		 aboutEdit:false,
		 projectabout:"",
		 projectMembers:[],
		 auth:this.$store.state.currentUser.user.id,
		 accessAllowed:false
    };
    },
    methods:{
			loadProject(){
				 axios.get('/api/v1/projects/'+this.$route.params.slug).
				 then(response=>{
						 this.project=response.data;
						 this.user=response.data.user[0];
						 this.getStage=this.project.stage.id;
						 this.projectname=this.project.name;
						 this.projectMembers=this.project.members;
						 this.checkMembersAndPermission();
						 this.$bus.emit('projectSlug',{slug:response.data.slug});
				 }).catch(error=>{
					 console.log(error.response.data.errors);
				 });
			},
      checkMembersAndPermission(){
				var authId=this.auth;
				var IsMember=false;
				 this.projectMembers.forEach(function(item,index){
					 if(item.pivot.user_id == authId){
					    IsMember = true;
					}
				 });
				 if(this.user.id == authId || IsMember == true){
					 return this.accessAllowed = true;
			 }
			},
			//Update project name methods
			updateName(){
					axios.patch('/api/v1/projects/'+this.project.slug,{
							name:this.projectname,
					}).then(response=>{
             	this.updateUrl(response.data.slug);
		          this.updateNameState(response.data.name,response.data.slug,response.data.msg);
					}).catch(error=>{
						  this.nameEdit = false;
						  this.projectname=this.project.name;
              this.showError(error);
					 });
			},
			updateUrl(url){
				const nextURL = 'http://127.0.0.1:8000/project/'+url;
				const nextTitle = 'Project new url';
				const nextState = { additionalInformation: 'Updated the URL with Slug' };
					window.history.replaceState(nextState, nextTitle, nextURL)
			},
			updateNameState(name,slug,msg){
				this.project.name=name;
				this.project.slug=slug;
				this.projectname=name;
				this.nameEdit = false;
				this.$vToastify.success(msg);
			},
			cancelUpdate(){
				this.nameEdit = false;
				this.projectname = this.project.name;
			},

			//update project about methods
			updateAbout(){
					axios.patch('/api/v1/projects/'+this.project.slug,{
							about:this.projectabout,
					}).then(response=>{
							this.project.about=response.data.about;
							this.projectabout=response.data.about;
							this.aboutEdit = false;
							this.$vToastify.success(response.data.msg);
					}).catch(error=>{
						this.aboutEdit = false;
						this.projectabout=this.project.about;
						 this.showError(error);
					 });
			},
			editAbout(){
				this.aboutEdit=true;
				this.projectabout=this.project.about;
			},
			aboutCancel(){
				this.aboutEdit=false;
				this.projectabout=this.project.about;
			},

			//show error messages
			showError(error){
				if(error.response.data.errors && error.response.data.errors.name){
						this.$vToastify.warning(error.response.data.errors.name[0]);
				}
				 if(error.response.data.errors && error.response.data.errors.about){
						this.$vToastify.warning(error.response.data.errors.about[0]);
					}
				if(error.response.data.error){
					this.$vToastify.warning(error.response.data.error);
				}

			}
    },
    mounted(){
			this.loadProject();
    },
		created(){
			this.$bus.$on('stageListners', (data) => {
					this.project.stage_updated_at = data.stage_updated
					this.project.stage = data.current_stage
					this.project.completed = data.completed
					this.project.postponed= data.postponed
					this.getStage=data.getStage
				})
					this.$bus.$on('taskResults', (data) => {
							axios.get('/api/v1/projects/'+this.project.slug+'?page=' + data.page)
			 				.then(response => {
			 					this.project.tasks = response.data.tasks;
			 				});
		 				})
						this.$bus.$on('Panel', (data) => {
								this.project.notes = data.notes
							})
						this.$bus.$on('removeMember',(data)=>{
							  this.project.members=data.members
						})
		},
}
</script>

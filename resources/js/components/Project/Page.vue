<template>
	<div v-if="this.show">
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
							<project-features :slug="project.slug"  :members="this.project.members" :name="this.project.name">
							</project-features>
						</div>
					</div>
					<div class="page-content">
						<div class="row">
							<div class="col-md-2">
								<Status :projectName='project.name' :start="project.created_at" :stage="project.stage"
								:completed="this.project.completed" :status="this.status" :score="this.project.score">
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
										<button v-if="permission.access" type="button" class="btn btn-link btn-sm" @click="nameEdit = true">Edit</button>
									</span>
								</p>
								<p class="content-info">
									Created On
									<span class="content-dot"></span>
									{{project.created_at}}
								</p>
								<p class="content-info">
									Created By<span class="content-dot"></span>
									<router-link :to="'/user/'+user.id+'/profile'" class="btn btn-link">{{user.name}}</router-link>
								</p>
							</div>
							<div v-if="this.project.deleted_at">
								<div class="alert alert-danger" role="alert">
									This project is abandoned to access project features active this project,
									or it will be deleted automatically after {{this.project.days_limit}} days from the abandoned date.
									<p>Abandoned on: <b v-text="this.project.deleted_at"></b> </p>
									<a class="btn btn-info" @click.prevent="restore()" >Restore Project</a>
								</div>
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
									<button v-if="permission.access" type="button" class="btn btn-link btn-sm" @click="editAbout()">Edit</button>
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
					:completed="project.completed" :stage_updated="project.stage_updated_at" :get_stage="this.getStage" :access="permission.access">
				</Stage>
				<br>
				<hr>
				<h3>RECENT ACTIVITIES</h3>
				<div class="row">
					<RecentActivities 
					:activities="project.activities" :slug="project.slug" :name="project.name">
					</RecentActivities>
					<div class="col-md-5">
						<div class="project-info">
							<div class="project-info_socre">
								<p class="project-info_score-heading">Status</p>
								<p class="project-info_score-point" :class="'project-info_score-point_'+this.status">{{this.project.score}}</p>
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
			<Task :slug="project.slug" :tasks="tasks" :access="permission.access" :projectMembers="this.project.members"></Task>
			<hr>
			<PanelFeatues :slug="project.slug" :notes="project.notes"
			:members="project.members" :owner="user" :access="permission.access" :ownerLogin="permission.owner"></PanelFeatues>
			<hr>
			<div>
      							
            <p><b>Online Users For Chat</b></p>
            <p v-for="user in  chatusers">{{user.name}} <span class="chat-circle"></span> </p>
            </div>

			<hr>
			<Chat :slug="project.slug" 
			:conversations="project.conversations" :users="project.members" :auth="this.auth"></Chat>
		</div>
	</div>
</div>
</div>
<!--<div v-else class="text-center mt-5">
    <h3>Thank you for your patience. The page is loading, and we're almost there!</h3>
    <div class="d-flex mt-3 justify-content-center align-items-center">
      <ring-loader :color=this.color :size="100" />
    </div>
  </div>-->
</template>
<script>
	import Status from './Status.vue'
	import Stage from './Stage.vue'
	import Task from './Panel/Task.vue'
	import PanelFeatues from './Panel/Features.vue'
	import RecentActivities from './RecentActivities.vue'
  import Chat from './Panel/Chat.vue'
  import { permission } from '../../auth'
  import { mapState, mapMutations, mapActions } from 'vuex';

export default{
	  components:{
	  	Status,
	  	Stage,
	  	Task,
	  	PanelFeatues,
	  	RecentActivities,
	  	Chat,
	  },

    data(){	
    return{
     color:'#301934', 
		 nameEdit:false,
		 aboutEdit:false,
		 projectname:'',
		 projectabout:'',
		 auth:this.$store.state.currentUser.user,
		 conversations:[],
     chatusers:[],
     Hot_Score: 21,
		 path:'',
		 members:'',
		 show:false
    };
    },

    created(){
    	const slug = this.$route.params.slug;
      this.loadProject(slug)
      .then(() => {
      	this.show=true;
      this.projectname = this.project.name;
      this.projectabout = this.project.about;
      this.members = this.project.members;
      this.archiveTask();
    })
    .catch(error => {
      console.log(error.response.data.errors);
    });
    },

    computed: {
    	...mapState('project',['project','user','getStage','tasks']),

    permission() {
      const {access, owner} = permission(this.auth.id, this.project.members, this.user.id);

      return {access, owner};
   },

    status() {
      return this.project.score > this.Hot_Score ? 'hot' : 'cold'
    },
  },

    methods:{
    ...mapActions('project',['loadProject']),
    ...mapMutations('project',['nameUpdate','aboutUpdate']),

			updateName(){
				axios.patch(`/api/v1/projects/${this.project.slug}`,{
							name:this.projectname,
					}).then(response=>{
						this.updateNameState(response.data.name,response.data.slug,response.data.message);
             	this.updateUrl(response.data.slug);
					}).catch(error=>{
						  this.nameEdit = false;
						  this.projectname=this.project.name;
              this.showError(error);
					 });
			},

			updateUrl(url){
				 window.history.replaceState(
          {additionalInformation: 'Updated the URL with Slug'},
          'Updated Project URL',
          `http://127.0.0.1:8000/projects/${url}`
          );
			},

			updateNameState(name,slug,msg){
				this.nameUpdate(name,slug);
				this.projectname=name;
				this.nameEdit = false;
				this.$vToastify.success(msg);
			},

			cancelUpdate(){
				this.nameEdit = false;
				this.projectname = this.project.name;
			},

			updateAbout(){
					axios.patch(`/api/v1/projects/${this.project.slug}`,{
							about:this.projectabout,
					}).then(response=>{
						  this.aboutUpdate(response.data.about);
							this.projectabout=response.data.about;
							this.aboutEdit = false;
							this.$vToastify.success(response.data.messge);
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

			restore(){
			  this.performAction(
			    'Yes, Make live again!',
			    axios.get(`/api/v1/projects/${this.project.slug}/restore`));
			},

			//show error messages
		  showError(err){
        const { data: { errors, error } } = err.response;
        if (errors) {
        Object.keys(errors).forEach(field => {
         this.$vToastify.warning(errors[field][0]);
      });
      } else if (error) {
        this.$vToastify.warning(error);
      }
    },

	  listenForActivity() {
	    Echo.channel('activity')
	      .listen('ActivityLogged', (e) => {
		      this.project.activities.unshift(e);
		  });
		},

		listenForNewMessage() {
      Echo.private(`conversations.${this.getProjectSlug()}`)
        .listen('NewMessage', (e) => {
          this.project.conversations.push(e);
      });
    },

    listenToDeleteConversation(){
      Echo.private(`deleteConversation.${this.getProjectSlug()}`)
        .listen('DeleteConversation', (e) => {
        this.project.conversations.splice(this.project.conversations.indexOf(e),1);
        this.$vToastify.success("conversation deleted");       
      });
    },

    connectToEcho(){
      Echo.join(`chatroom.${this.getProjectSlug()}`)
        .here(members => {
          this.chatusers = members;
        })
         .joining(auth => {
          this.chatusers.push(auth);
          this.$vToastify.info(`${auth.name} joined project conversation`);
        })
         .leaving(auth => {
          this.chatusers.splice(this.chatusers.indexOf(auth), 1);
          this.$vToastify.info(`${auth.name} leave project conversation`);
        });
      },

      archiveTask(){
      this.$bus.on('archiveTask', (taskId) => {
    if (this.project.activities.subject_id !== null) {
        this.project.activities = this.project.activities.filter(activity => activity.subject_id !== taskId);
    }
    console.log('eventliten');
});
      },
      unarchiveTask(){

      }
  },

    mounted(){
      this.listenForNewMessage();
			this.listenToDeleteConversation();
			this.listenForActivity();
      this.path=this.getProjectSlug();
      this.connectToEcho();
    },

    beforeDestroy(){
      Echo.leave('chatroom.'+this.path);
  },
}
</script>
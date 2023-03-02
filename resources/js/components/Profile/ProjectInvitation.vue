<template>
	<div>
	              <p class="pro-info">Project Invitations</p>
              
    <!-- Only Profile owner access this area-->
              
<div>

<div class="row" v-if="this.projects !== 0">

<div class="col-md-5 ml-3" v-for="project in this.projects">

  <div class="card" :id="'project-'+project.id">

     <p class="mt-3">Project Name: <a v-bind:href="project.slug" target="_blank"><b>{{project.name}}</b></a>
     </p>
     <p>Owner Name: <a v-bind:href="project.user.id" target="_blank"><b>{{project.user.name}}</b></a>
     </p>
     <p>Invitation Received On: <b>
     {{project.invitation_sent_at}}</b></p>

  <p class="text-center">
  <button class="btn btn-primary btn-sm" @click.prevent="becomeMember(project.id)">Become Member
  </button>
<button class="btn btn-danger btn-sm" @click.prevent="rejectInvitation(project.id)">Ignore Invitation</button>
</p>
   <div class="card-footer">
   <p>
    <span class="float-right">Created_at: <b>{{project.created_at}}</b></span>
</p>
    </div>
</div>
</div>
</div>
<div v-else>
  <h3>No project Invitation found</h3>
</div>
</div>
</div>
</template>

<script>

export default{
	props:['user','projects'],

	methods:{

  becomeMember(id){
         axios.get('/project/'+id+'/accept-invitation',{
           }).then(response=>{
              this.$vToastify.success("You have accepted the project invitation");
             setTimeout(()=>{
             window.location.href='/api/projects/'+id;
        },3000)
           }).catch(error=>{
                this.$vToastify.warning("Error! Try Again");
            });
  },

  rejectInvitation(id){
       axios.get('/project/'+id+'/cancel',{
           }).then(response=>{
          this.$vToastify.info("The project request has rejected");
                  $("#project-"+id).fadeOut(300);
           }).catch(error=>{
                this.$vToastify.warning("Error! Try Again");
            });
  },
    }

}	

</script>
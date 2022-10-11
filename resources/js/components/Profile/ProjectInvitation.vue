<template>
	<div>
	              <p class="pro-info">Project Invitations</p>
              
              <div v-if="authorize('profileOwner',user)">

<div class="row" v-if="this.members != 0">

<div class="col-md-5 ml-3" v-for="member in this.members">

  <div class="card" v-if="member.pivot.active == 0" :id="'project-'+member.id">

     <p class="mt-3">Project Name: <a v-bind:href="'/api/projects/'+member.id" target="_blank"><b>{{member.name}}</b></a>
     </p>
     <p>Owner Name: <a v-bind:href="'/user/'+member.id+'/profile'" target="_blank"><b>{{member.owner.name}}</b></a>
     </p>
        <p>Invitation Received On: <b>{{member.pivot.created_at | timeDate}}</b></p>

  <p class="text-center">
  <button class="btn btn-primary btn-sm" @click.prevent="becomeMember(member.id)">Become Member
  </button>
<button class="btn btn-danger btn-sm" @click.prevent="rejectInvitation(member.id)">Ignore Invitation</button>
</p>
   <div class="card-footer">
   <p>
    <span class="float-right">Created_at: <b>{{member.created_at | timeExactDate}}</b></span>
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
	props:['user','members'],

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
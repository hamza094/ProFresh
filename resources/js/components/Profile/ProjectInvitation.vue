<template>
  <div>
	<p class="pro-info">Project Invitations</p>
    <div class="row" v-if="this.projects">

    <div class="col-md-5" v-for="project in this.projects">

    <div class="card invitation border-secondary">
    <div class="card-header text-center">
        Project Name: 
        <router-link :to="'/projects/'+project.slug">{{project.name}}</router-link> 
    </div>

    <div class="card-body mt-1 text-center">
    <p>Owner Name: 
    <router-link :to="'/user/'+project.user.id+'/profile'" target="_blank">{{project.user.name}}</router-link>    
    </p>

     <p class="text-center">
      <button class="btn btn-primary btn-sm" @click.prevent="becomeMember(project.slug)">Become Member</button>
      <button class="btn btn-danger btn-sm" @click.prevent="rejectInvitation(project.slug)">Ignore Invitation</button>
    </p>  
          
    </div>

   <div class="card-footer">
    <p> 📨
    Invitation Received On:: <b>{{project.invitation_sent_at}}</b>
    </p>
    </div>

   </div>
   </div>
   </div>
   <div v-else>
     <h3>No project Invitation found</h3>
    </div>
</div>
</template>

<script>
import { mapMutations } from 'vuex';

export default{
	props:['projects'],

	methods:{
      ...mapMutations('profile',['updateInvitations']),

  becomeMember(slug){
         axios.get('/api/v1/projects/'+slug+'/accept-invitation',{
           }).then(response=>{
              this.$vToastify.success(response.data.message);
             this.updateInvitations(response.data.project.id);
           }).catch(error=>{
            console.log(error);
                this.$vToastify.warning("Error! Try Again");
            });
  },

  rejectInvitation(slug){
       axios.get('/api/v1/projects/'+slug+'/ignore',{
           }).then(response=>{
          this.$vToastify.info(response.data.message);
          this.updateInvitations(response.data.project.id);
           }).catch(error=>{
                this.$vToastify.warning("Error! Try Again");
            });
  },
    }

}	

</script>
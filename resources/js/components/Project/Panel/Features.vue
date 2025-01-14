<template>
  <div>
    <div class="project-note">
      <div id="wrapper">
        <!-- Project Notes Section -->
        <p><b>Add Project Note:</b></p>

<!-- <SubscriptionCheck> -->

    <form v-if="access" 
    id="paper"
     method="post"
     @keyup.enter.prevent="ProjectNote">

      <textarea placeholder="Write Project Notes"
       id="text"
        name="notes"
         rows="4"
          v-model="form.notes"
           v-text="this.notes">
      </textarea>
      <br>
  </form>

    <textarea v-if="!access"
     placeholder="Only project members and owners are allowed to write project notes."
      id="text"
       rows="4"
        v-model="form.notes"
         v-text="this.notes"
          readonly>
    </textarea>
<!-- </SubscriptionCheck> -->
    <br>
</div>
    </div>
    <hr>

    <div class="invite" v-if="access">
      <p><b>Project Invitations:</b></p>

       <input type="text"
        placeholder="Search user for invitation" class="form-control"
        v-model="query"
        @input="searchUsers"
        />

       <div class="invite-list">

        <ul>

        <li v-if="isLoading" class="  loading-spinner-container">
          <div class="loading-spinner"></div>
        </li>

         <!-- Show "no users found" message -->
        <li v-else-if="!isLoading && query && results.length === 0">
          No users found.
        </li>

        <!-- Show user results -->
        <li v-else-if="results.length > 0 && query" v-for="result in results.slice(0, 5)" :key="result.id">
          <div @click.prevent="inviteUser(result.email)">
            {{ result.name }} ({{ result.email }})
          </div>
        </li>
        </ul>
      </div>
    </div>
    <hr>

    <div class="project_members">
      <div class="task-top">
        <p><b>Project Members</b><a data-toggle="collapse" href="#memberProject" role="button" aria-expanded="false" aria-controls="memberProject">
          <i class="fas fa-angle-down float-right"></i></a></p>
      </div>

      <div class="collapse" id="memberProject">
        <div class="row">
        <div v-for="member in members" :key="member.id" class="col-6">
          <div class="project_members-detail text-center">
               <router-link :to="'/user/'+member.uuid+'/profile'">
                   <img v-if="member.avatar" :src="member.avatar" alt="" class="img-fluid rounded-circle">
                   <p>
                    <span v-if="member.uuid == owner.uuid" 
                    class="badge badge-success">project owner
                    </span>
                    <br>
                    <span>{{member.name}}</span>
                    <br>
                    <span>({{member.username}})</span>
                   </p>
                   <p></p>
               </router-link>
              <a v-if="ownerLogin && member.uuid !== owner.uuid"  rel="" role="button" @click.prevent="removeMember(member.uuid,member)" class="text-danger">Remove</a>
              </div>
        </div>
      </div>
</div>
    </div>

    <div class="project_members">
      <div class="task-top">
        <p><b>Pending Members</b><a data-toggle="collapse" href="#pendingMembers" role="button" aria-expanded="false" aria-controls="pendingMembers">
          <i class="fas fa-angle-down float-right"></i></a></p>
      </div>

      <div class="collapse" id="pendingMembers">
    <div class="row">
        <!-- Check if pendingMembers array is not empty -->
        <template v-if="pendingMembers.length">
            <div v-for="member in pendingMembers" :key="member.id" class="col-6">
                <div class="project_members-detail text-center">
                    <router-link :to="'/user/' + member.uuid + '/profile'">
                        <img v-if="member.avatar" :src="member.avatar" class="img-fluid rounded-circle" alt="">
                        <p>
                            <span>{{ member.name }}</span>
                            <br>
                            <span>({{ member.username }})</span>
                        </p>
                        <p></p>
                    </router-link>
                    <span>{{member.invitation_sent_at}}</span>
                    <br>
                    <a v-if="ownerLogin && member.uuid !== owner.uuid" 
                       rel="" 
                       role="button" 
                       @click.prevent="cancelRequest(member.uuid, member)" class="text-danger">Cancel</a>
                </div>
            </div>
        </template>
        
        <!-- Show a message when no members are found -->
        <template v-else>
            <div class="col-12 text-center">
                <p>No pending or invited members found.</p>
            </div>
        </template>
    </div>
</div>

    </div>
</div>

</template>

<script>
import { mapMutations } from 'vuex';
import SubscriptionCheck from '../../SubscriptionChecker.vue';
import { debounce } from 'lodash';

export default{
    components:{SubscriptionCheck},
  props:['slug','notes','members','owner','access','ownerLogin'],
  data(){
    return{
      form:{
        notes:"",
      },
      query: null,
      isLoading: false,
      results: [],
      errors:{},
      pendingMembers:[],
    }
  },
   watch:{
      'query': debounce(function(newQuery) {
      this.searchUsers(newQuery);
    }, 500),
    },

    created(){
      this.loadPendingRequests();
    },

  methods:{
        ...mapMutations('project',['updateNotes','noteScore','updateScore','detachMember']),

    ProjectNote(){
      this.$Progress.start();
  document.getElementById('text').blur();

      axios.patch('/api/v1/projects/'+this.slug,{
        notes:this.form.notes,
      }).then(({ data }) => {
        const { project, message } = data;
        this.$Progress.finish();
        this.updateNotes(project.notes);
        this.$vToastify.success(message);
        this.noteScore(project.score);
      }).catch(error=>{
          this.$Progress.fail();
          const dataErrors = error.response.data.errors;

          if(dataErrors && dataErrors.notes[0]){
            this.$vToastify.warning(dataErrors.notes[0]);
        }
        if(error.response.data.error){
  				this.$vToastify.warning(error.response.data.error);
  			}
          this.form.notes=this.notes;
      }).finally(() => {
       document.getElementById('focus-target').focus();
    });
    },

    searchUsers(query) 
    {
      if (!this.query) {
        this.results = [];
        return;
      }
      this.isLoading = true;

    axios.get('/api/v1/users/search', { params: { query: this.query } })
   .then(response => {
    this.results = response.data;
  })
   .catch(error => {
      this.$vToastify.warning(error.response.data.error);
   }).finally(() => {
        this.isLoading = false;
    });
 },

  inviteUser(userEmail){
      axios.post('/api/v1/projects/'+this.slug+'/invitations',{
      email:userEmail,
     },{ useProgress: true }).then(response=>{
       this.query='';
       this.results='';
       this.$vToastify.success(response.data.message);
   }).catch(error=>{
       this.query='';
       this.results='';

      const errors = error.response?.data?.errors;
      
      if (error.response?.status === 422 && errors) {
        Object.values(errors).flat().forEach(message => {
          this.$vToastify.warning(message);
        });
      } else {
        this.$vToastify.warning(error.response?.data?.error || "An unexpected error occurred.");
      }
   })
 },

 removeMember(id,member){
   var self = this;
    this.sweetAlert('Yes, Remove Member').then((result) => {
  if (result.value) {
  axios.get('/api/v1/projects/'+this.slug+'/remove/member/'+id,{ useProgress: true }).then(response=>{
      this.detachMember(response.data.user.uuid);
      self.$vToastify.info(response.data.message);
}).catch(error=>{
       this.$vToastify.warning(
          error.response?.data?.error || "Failed to remove the member. Try again."
        );
  });
 }
 })
 },

 cancelRequest(userId) {
  this.sweetAlert("Yes, cancel request").then((result) => {
    if (!result.value) return;

    axios
      .get(`/api/v1/projects/${this.slug}/cancel/invitation/users/${userId}`, { useProgress: true })
      .then((response) => {
        this.pendingMembers = this.pendingMembers.filter(
          (pendingMember) => pendingMember.uuid !== userId
        );
        this.$vToastify.info(response.data.message);
      })
      .catch((error) => {
        this.$vToastify.warning(
          error.response?.data?.message || "Failed to cancel the request. Try again."
        );
      });
  });
},

 loadPendingRequests(){
     axios.get(`/api/v1/projects/${this.slug}/pending/invitations`)
       .then(response=>{
       this.pendingMembers=response.data.pending_invitations;
   }).catch(error=>{
    this.$vToastify.warning(
      error.response?.data?.message || "Failed to load pending invitations."
    );
   })
 },

  },
}
</script>

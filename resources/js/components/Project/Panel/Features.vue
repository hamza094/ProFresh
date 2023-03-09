<template>
  <div>
    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>

    <form v-if="access" id="paper" method="post"@keyup.enter.prevent="ProjectNote">
      <textarea placeholder="Write Project Notes" id="text" name="notes" rows="4" v-model="form.notes" v-text="this.notes"></textarea>
      <br>
  </form>
    <textarea v-if="!access" placeholder="Only project members and owners are allowed to write project notes." id="text" rows="4" v-model="form.notes" v-text="this.notes" readonly></textarea>
    <br>
</div>
    </div>
    <hr>

    <div class="invite" v-if="access">
      <p><b>Project Invitations:</b></p>
       <input type="text" placeholder="Search user for invitation" class="form-control" v-model="query">
       <div class="invite-list">
        <ul v-if="results.length > 0 && query">
          <li v-for="result in results.slice(0,5)" :key="result.id">
              <div @click.prevent="inviteUser(result.url)">{{result.title}} ({{result.searchable.email}})</div>
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
        <div v-for="member in members" :key="member.id">
          <div class="project_members-detail">
               <router-link :to="'/user/'+member.id+'/profile'">
                   <img v-if="member.avatar" :src="member.avatar" alt="">
                   <p>
                    <span v-if="member.id == owner.id" 
                    class="badge badge-success">project owner
                    </span>
                    <br>
                    <span>{{member.name}}</span>
                    <br>
                    <span>({{member.username}})</span>
                   </p>
                   <p></p>
               </router-link>
              <a v-if="ownerLogin && member.id !== owner.id"  rel="" role="button" @click.prevent="removeMember(member.id,member)">x</a>
              </div>
        </div>
      </div>
</div>
    </div>
</div>

</template>

<script>
export default{
  props:['slug','notes','members','owner','access','ownerLogin'],
  watch: {
  query(after, before) {
    this.searchUsers();
  },
},
  data(){
    return{
      form:{
        notes:"",
      },
      query: null,
      results: [],
      errors:{},
    }
  },
  methods:{
    ProjectNote(){
      axios.patch('/api/v1/projects/'+this.slug,{
        notes:this.form.notes,
      }).then(response=>{
        this.$bus.emit('Panel',{notes:response.data.notes});
        this.$vToastify.success("Notes Updated");
        this.$bus.emit('score',{score:response.data.score});
        console.log(response.data.score);
      }).catch(error=>{
          if(error.response.data.errors && error.response.data.errors.notes[0]){
            this.$vToastify.warning(error.response.data.errors.notes[0]);
        }
        if(error.response.data.error){
  				this.$vToastify.warning(error.response.data.error);
  			}
          this.form.notes=this.notes;
      })
    },
    searchUsers() {
    axios.get('/api/v1/users/search', { params: { query: this.query } })
   .then(response => this.results = response.data)
   .catch(error => {
     this.$vToastify.warning(error.response.data.error);
   });
 },
  inviteUser(user){
      axios.post('/api/v1/projects/'+this.slug+'/invitations',{
      email:user,
     }).then(response=>{
       this.query='';
       this.results='';
       this.$vToastify.success(response.data.message);
   }).catch(error=>{
       this.query='';
       this.results='';
       this.$vToastify.warning(error.response.data.error);
   })
 },
 removeMember(id,member){
   var self = this;
    this.sweetAlert('Yes, Remove Member').then((result) => {
  if (result.value) {
  axios.get('/api/v1/projects/'+this.slug+'/remove/'+id).then(response=>{
      this.$bus.emit('removeMember',{members:response.data.members});
      self.$vToastify.info(response.data.message);
}).catch(error=>{
      swal.fire("Failed!","There was  an errors","warning");
  });
 }
 })
 }
  },
}
</script>

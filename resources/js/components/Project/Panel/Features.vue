<template>
  <div>
    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>
    <form v-if="access" id="paper" method="post" @keyup.enter="ProjectNote">
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
        <div class="">
          <router-link :to="'/user/'+owner.id+'/profile'">
            <p> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvsQZEtAw99ePVsNhLCexVsSKct6D13NluBQ&usqp=CAU" alt="">
              <span>Project owner: <b>{{owner.name}}</b></span>
            </p>
          </router-link>
      </div>
      <hr>
      <h6 class="text-center"><b>Other Members </b></h6>
      <div v-if="this.members == 0">
        <p class="text-center"><b>No other project members have been found!</b></p>
      </div>
        <div v-else class="row">
        <div v-for="member in members" class="col-md-4" :key="member.pivot.user_id">
          <div class="project_members-detail">
               <router-link :to="'/user/'+member.pivot.user_id+'/profile'">
                 <!-- <img :src="member.avatar_path" v-if="member.avatar_path!=null">-->
                   <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvsQZEtAw99ePVsNhLCexVsSKct6D13NluBQ&usqp=CAU" alt="">
                   <p>{{member.name.substring(0,12)}}</p>
               </router-link>
              <a v-if="ownerLogin"  rel="" role="button" @click.prevent="removeMember(member.pivot.user_id,member)">x</a>
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
       this.$vToastify.success(response.data.msg);
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
      self.$vToastify.info(response.data.msg);
}).catch(error=>{
      swal.fire("Failed!","There was  an errors","warning");
  });
 }
 })
 }
  },
}
</script>

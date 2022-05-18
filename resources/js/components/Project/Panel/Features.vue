<template>
  <div>
    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>
    <form id="paper" method="post" @keyup.enter="ProjectNote">
      <textarea placeholder="Write Project Notes" id="text" name="notes" rows="4" v-model="form.notes" v-text="this.notes"></textarea>
      <br>
  </form>
</div>
    </div>
    <hr>

    <div class="invite">
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
</div>

</template>

<script>
export default{
  props:['slug','notes'],
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
  },
}
</script>

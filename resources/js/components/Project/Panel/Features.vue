<template>
  <div>
    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>
    <form id="paper" method="post" @keyup.enter="ProjectNote">
      <textarea placeholder="Write project notes" id="text" name="notes" rows="4" v-model="form.notes">{{this.notes}}</textarea>
      <br>
  </form>
</div>
    </div>
</div>

</template>

<script>
export default{
  props:['slug','notes'],
  data(){
    return{
      form:{
        notes:"",
      },
      errors:{},
    }
  },
  methods:{
    ProjectNote(){
      axios.patch('/api/v1/projects/'+this.slug+'/notes',{
        notes:this.form.notes,
      }).then(response=>{
        this.$bus.emit('Panel',{notes:response.data.notes});
        this.$vToastify.success("Notes Updated");
      }).catch(error=>{
        if(error.response.data.errors){
          if(error.response.data.errors.notes[0]){
            this.$vToastify.warning(error.response.data.errors.notes[0]);
        }
        }
        if(error.response.data.error){
  				this.$vToastify.warning(error.response.data.error);
  			}
          this.form.notes=this.notes;
      })
    },
  },
}
</script>

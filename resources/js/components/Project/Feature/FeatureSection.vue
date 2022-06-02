<template>

    <div class="float-right">

    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-project')">Edit Project</button>

    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content" v-if="authorize('projectOwner',project)"
    @click="forgetProject"><i class="far fa-trash-alt"></i> Forget</li>

    <!--<li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-mail')"><i class="far fa-envelope"></i> Email</li>

    <li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-sms')"><i class="fas fa-mobile-alt"></i> Send SMS</li> !-->

    <!--Send a message instead of separate SMS and email
    <li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-message')"><i class="far fa-envelope"></i>Send Message</li>-->

    <a v-bind:href="'/api/projects/' + this.project.id +'/export'"> <li class="feature-dropdown_item-content" @click="projectExport"><i class="fas fa-upload"></i>Export</li></a>

    <li class="feature-dropdown_item-content" v-if="authorize('projectOwner',project)" @click="deleteProject"><i class="far fa-trash-alt"></i> Delete</li>
  </ul>
</span>
    </span>

   <ProjectUpdate :project=project></ProjectUpdate>

   <ProjectSms :project=project :members=members></ProjectSms>

   <ProjectMail :project=project :members=members></ProjectMail>

    </div>

</template>


<script>

  import ProjectSms from './ProjectSms'
  import ProjectMail from './ProjectMail'

export default {

  components: {ProjectSms,ProjectMail},

    props:['project','subscribe','members'],
    data() {
        return {
          subscription:this.subscribe,
          projectmembers:this.members,
           featurePop:false,
            errors:{}
        };
    },
    watch:{
        stagePop(featurePop){
            if(featurePop){
                document.addEventListener('click',this.zeroIfClickedOutside);
            }
        }
    },
    methods: {
        zeroIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.featurePop=false;
                document.removeEventListener('click',this.zeroIfClickedOutside);
            }
        },

        forgetProject(){
          var self=this;
        this.sweetAlert('Yes, forget it!').then((result) => {
        if (result.value) {
         axios.delete('/api/projects/'+this.project.id).then(function(){
         self.redirectSuccess('Project forgetted successfully','/dashboard');
         }).catch(function(){
             swal.fire("Failed!","There was something wrong.","warning");
         });
     }
       })
     },

     deleteProject(){
      var self = this;
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.get('/api/projects/'+this.project.id+'/delete').then(function(){
      self.redirectSuccess('Project deleted successfully','/dashboard');
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

 projectExport(){
this.$vToastify.success("Data Export Successfully");
},

projectSubscribe(){
   axios.post('/api/projects/'+this.project.id+'/subscribe').
   then(response=>{
       this.subscription=true;
     this.$vToastify.success("Project Subscribed Successfully");
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},

projectUnSubscribe(){
axios.delete('/api/projects/'+this.project.id+'/unsubscribe').
then(response=>{
  this.subscription=false;
  this.$vToastify.info("Project UnSubscribed Successfully");
}).catch(error=>{
  console.log(error.response.data.errors);
});
},
  }
}
</script>

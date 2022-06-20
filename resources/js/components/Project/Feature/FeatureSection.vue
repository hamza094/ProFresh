<template>

    <div class="float-right">

    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content"
    @click="abandon()"><i class="fas fa-eye-slash"></i> Abandon</li>

    <li class="feature-dropdown_item-content"><i class="far fa-envelope"></i>Send Mail or Sms</li>

    <!--<li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-sms')"><i class="fas fa-mobile-alt"></i> Send SMS</li> !-->

    <!--Send a message instead of separate SMS and email
    <li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-message')"><i class="far fa-envelope"></i>Send Message</li>-->

    <a v-bind:href="'/api/projects/' + this.slug +'/export'"> <li class="feature-dropdown_item-content" @click="projectExport"><i class="fas fa-upload"></i>Export</li></a>

    <li class="feature-dropdown_item-content" @click="deleteProject"><i class="fas fa-ban"></i> Delete</li>
  </ul>
</span>
    </span>

  <!-- <ProjectSms :slug=slug :members=members></ProjectSms>-->

   <!--<ProjectMail :slug=slug :members=members></ProjectMail>-->

    </div>

</template>


<script>

  //import ProjectSms from './Sms'
  //import ProjectMail from './Mail'

export default {

  //components: {ProjectSms,ProjectMail},

    props:['slug','members'],
    data() {
        return {
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

        abondon(){
          var self=this;
        this.sweetAlert('Yes, abandon it!').then((result) => {
        if (result.value) {
         axios.delete('/api/v1/projects/'+this.slug).then(function(){
           self.$router.push('/dashboard');
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
      axios.get('/api/v1/projects/'+this.slug+'/delete').then(function(){
        self.$router.push('/dashboard');
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

 projectExport(){
this.$vToastify.success("Data Export Successfully");
},

  }
}
</script>

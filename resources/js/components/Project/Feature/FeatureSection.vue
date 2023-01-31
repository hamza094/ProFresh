<template>

    <div class="float-right">

    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content"
    @click="abandon()"><i class="fas fa-eye-slash"></i> Abandon</li>

    <li class="feature-dropdown_item-content"  @click="$modal.show('project-message')"><i class="far fa-envelope"></i>Send Mail or Sms</li>

    <li class="feature-dropdown_item-content" @click="exportProject()"><i class="fas fa-upload"></i> Export</li>

    <li class="feature-dropdown_item-content" @click="deleteProject"><i class="fas fa-ban"></i> Delete</li>
  </ul>
</span>
    </span>
   <ProjectMessage :slug=slug :members=members></ProjectMessage>

    </div>

</template>

<script>
import fileDownload from 'js-file-download';
import ProjectMessage from './Message.vue'

export default {

  components: {ProjectMessage},

    props:['slug','members','name'],
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

      abandon(){
          this.performAction(
            'Yes, abandon it!',
            axios.delete('/api/v1/projects/'+this.slug)
          );
      },

     deleteProject(){
       this.performAction(
         'Yes, delete it!',
         axios.get('/api/v1/projects/'+this.slug+'/delete')
       );
  },
 exportProject(){
   axios.get('/api/v1/projects/'+this.slug+'/export', {
  	responseType: 'blob',
    headers: {'Accept': 'multipart/form-data'}
  }).then(response => {
    fileDownload(response.data, 'Project '+this.slug+'.xls');
      }).catch(error => {
          console.log(error.response.data)
      })
},

  }
}
</script>

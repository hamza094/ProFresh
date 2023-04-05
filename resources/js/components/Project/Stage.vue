<template>
<div>
  <div>
    <div>
      <p><span><b>Project Stage Last Updated:</b> {{stage_updated}}</span></p>
    </div>
  <div class="row" v-if="access">
    <div v-for="stage in stages" class="arrow-pointer-pd" @click="stageChange(stage.id)" :key="stage.id">
       <p :class="stageCondition(stage.id)" class="arrow-pointer"><span class="arrow-pointer-span">{{stage.id}}. {{stage.name}}</span></p>
     </div>
     <div class="stage-dropdown" @click="stagePop = !stagePop">
       <p :class="lastStage()" class="arrow-pointer"><span class="arrow-pointer-span">{{status}} <i class="fas fa-angle-double-down"></i></span></p>
       <div class="stage-dropdown_item" v-show=stagePop>
         <ul>
           <li v-if="!completed" class="stage-dropdown_item-content" @click="projectClose">Closure</li>
           <li v-if="projectstage" class="stage-dropdown_item-content" @click="$modal.show('stage-reason')">Postponed</li>
         </ul>
       </div>
    </div>
  </div>
  <div v-else>
    <h5>Only project members and owners are allowed to change the project stage.</h5>
  </div>
</div>
<div>
  <modal name="stage-reason" :clickToClose=false>
    <div class="panel-top_content">
        <span class="panel-heading">Project Satge Postponed</span>
        <span class="panel-exit float-right" role="button" @click.prevent="$modal.hide('stage-reason')">x</span>
    </div>
    <hr>
      <div class="panel-top_content">
        <div class="form-group">
           <label for="unqstage" class="label-name">Reason of project to be Postponed:</label>
          <select class="custom-select" id="unqstage" name="unqstage" v-model="reason" title="Some placeholder text...">
            <option value="Junk Project">Junk Project</option>
            <option value="Unable to reach">Unable to reach</option>
            <option value="Not intrested">Not intrested</option>
          </select>
        </div>
      </div>
      <div class="panel-bottom">
          <div class="panel-top_content float-right">
              <button class="btn panel-btn_close" @click.prevent="$modal.hide('stage-reason')">Cancel</button>
             <button class="btn panel-btn_save" @click.prevent="postpone">Save</button>
          </div>
      </div>
</modal>
</div>
</div>
</template>

<script>
  import { mapMutations } from 'vuex';

  export default{
    props:['slug','projectstage','completed','stage_updated','postponed','get_stage','access'],
    data(){
       return{
         activeStage:'',
         stagePop:false,
         reason:'',
         stages:{},
         status:'',
         stageUpdation:'',
       }
    },
    watch:{
        stagePop(stagePop){
            if(stagePop){
                document.addEventListener('click',this.offIfClickedOutside);
            }
        }
    },
    methods:{
      ...mapMutations('project',['updateStage']),

      stageCondition(stageId) {
        if(this.projectstage){
        const activeStage = stageId === this.projectstage.id ? 'current' : 'stages';
         this.activeStage = activeStage;
         return activeStage;
      }

      if(!this.projectstage){
        if(this.completed){
          this.activeStage="closed";
           return 'closed';
        }
        this.activeStage="postpone";
         return 'postpone';
      }

  },

      lastStage(){
        if(!this.projectstage && this.completed){
            this.status="Closed";
            return "closed";
        }
        if(!this.projectstage && !this.completed){
          this.status="Postponed";
          return "postpone";
        }
        if(this.projectstage && !this.completed){
          this.status="Clo/Pos..";
          return "stages";
        }
      },

  updateProject(data) {
  axios.patch('/api/v1/projects/' + this.slug + '/stage', data)
    .then(response => {
      const project = response.data.project;

      let eventData = {
        completed: data.completed || 0,
        current_stage: project.stage || null,
        stage_updated: project.stage_updated_at,
        postponed: project.postponed || null,
        getStage: project.stage ? project.stage.id : 0
      };
      this.eventListener(eventData);
      this.$vToastify.success("Successfully update");
    })
    .catch(error => {
      this.$vToastify.error("Error in Project Phase Conversion");
    });
},  

  stageChange(stageId) {
  if (stageId === this.get_stage) {
    return this.$vToastify.error("Stage already selected");
  }

  this.updateProject({ stage: stageId });
},
      
 postpone() {
   this.updateProject({ postponed: this.reason });
   this.$modal.hide('stage-reason');
},

 projectClose() {
  this.updateProject({ completed: 'true' });  
},

 loadStages(){
    axios.get('/api/v1/stages').
    then(response=>{
       this.stages=response.data;
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},

eventListener(data){
  this.updateStage(data);
},

  offIfClickedOutside(event){
      if(!event.target.closest('.stage-dropdown')){
        this.stagePop=false;
        document.removeEventListener('click',this.offIfClickedOutside);
    }
  },
 },
 mounted(){
      this.loadStages();
    },
  }
</script>

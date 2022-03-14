<template>
<div>
  <div>
    <div>
      <p><span><b>Project Stage Last Updated:</b> {{stage_updated}}</span></p>
    </div>
  <div class="row">
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
  export default{
    props:['slug','projectstage','completed','stage_updated','postponed','check_stage'],
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
      stageCondition(stageId){
        if(this.projectstage){
          if(stageId == this.projectstage.id){
             this.activeStage="current";
             return 'current';
          }
          this.activeStage="stages";
           return 'stages';
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
  stageChange(stageId){
    if(stageId !== this.check_stage){
    axios.patch('/api/v1/projects/'+this.slug+'/stage',{
    stage:stageId
  }).then(response=>{
      this.eventListener(0,response.data.stage,response.data.stage_updated_at,null,response.data.stage.id);
     this.$vToastify.success("Updating project stage...");
  }).catch(error=>{
     this.$vToastify.error("Error in Project Phase Conversion");
  });
}
 },
  postpone(){
  axios.patch('/api/v1/projects/'+this.slug+'/stage',{
    stage:0,
    postponed:this.reason
  }).then(response=>{
    this.eventListener(0,null,response.data.stage_updated_at,this.reason,0);
   this.$vToastify.success("Postponeding project...");
   this.$modal.hide('stage-reason');
  }).catch(error=>{
    this.$vToastify.error("Error in Project Postpone");
  });
},
 projectClose(){
   axios.patch('/api/v1/projects/'+this.slug+'/stage',{
   stage:0
 }).then(response=>{
     this.eventListener(1,null,response.data.stage_updated_at,null,0);
    this.$vToastify.success("Sucessfully closing project...");
 }).catch(error=>{
    this.$vToastify.error("Error in Project Closing");
 });
},
 loadStages(){
    axios.get('/api/v1/stages').
    then(response=>{
       this.stages=response.data;
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},
eventListener($completed,$currentStage,$stageUpdated,$reason,$checkStage){
  this.$bus.emit('stageListners',{completed:$completed,current_stage:$currentStage,
    stage_updated:$stageUpdated,postponed:$reason,checkStage:$checkStage});
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

<template>
<div>
  <div>
    <div>
      <p><span><b>Project stage changed:</b> {{this.project.updated_at | timeExactDate}}</span></p>
    </div>
  <div class="row">
    <div class="arrow-pointer-pd" @click="initial">
      <p class="arrow-pointer unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">Initial Phase</span></p>
      <p class="arrow-pointer clo-bg" v-else-if="isSelected == 6"><span class="arrow-pointer-span">Initial Phase</span></p>
      <p class="arrow-pointer-select" v-else="isSelected > 0"><span class="arrow-pointer-span">Initial Phase</span></p>
    </div>

     <div class="arrow-pointer-pd" @click="defination">
       <p class="arrow-pointer unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">2. Defination</span></p>
       <p class="arrow-pointer clo-bg" v-else-if="isSelected == 6"><span class="arrow-pointer-span">2. Defination</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 1"><span class="arrow-pointer-span">2. Defination</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">2. Defination</span></p>
    </div>

     <div class="arrow-pointer-pd" @click="design">
       <p class="arrow-pointer unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">3. Designing</span></p>
       <p class="arrow-pointer clo-bg" v-else-if="isSelected == 6"><span class="arrow-pointer-span">3. Designing</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 2"><span class="arrow-pointer-span">3. Designing</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">3. Designing</span></p>
    </div>

     <div class="arrow-pointer-pd" @click="develop">
       <p class="arrow-pointer unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">4. Developing</span></p>
       <p class="arrow-pointer clo-bg" v-else-if="isSelected == 6"><span class="arrow-pointer-span">4. Developing</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 3"><span class="arrow-pointer-span">4. Developing</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">4. Developing</span></p>
    </div>

     <div class="arrow-pointer-pd" @click="execute">
       <p class="arrow-pointer unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">5. Execution</span></p>
       <p class="arrow-pointer clo-bg" v-else-if="isSelected == 6"><span class="arrow-pointer-span">5. Execution</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 4"><span class="arrow-pointer-span">5. Execution</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">5. Execution</span></p>
    </div>

     <div class="stage-dropdown" @click="stagePop = !stagePop">
       <p class="arrow-pointer arrow-pointer-unq" v-if="isSelected == 0"><span class="arrow-pointer-span">Postponed <i class="fas fa-angle-double-down"></i></span></p>
       <p class="arrow-pointer arrow-pointer-clo" v-else-if="isSelected == 6"><span class="arrow-pointer-span">6. Closure <i class="fas fa-angle-double-down"></i></span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 5"><span class="arrow-pointer-span">Clo/Pos ...<i class="fas fa-angle-double-down"></i></span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span pr-2">Clo/Pos ...<i class="fas fa-angle-double-down"></i></span></p>
       <div class="stage-dropdown_item" v-show=stagePop>
         <ul>
           <li class="stage-dropdown_item-content" @click="projectClosure">Closure</li>
           <li class="stage-dropdown_item-content" @click="$modal.show('stage-reason')">Postponed</li>
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
              <button class="btn panel-btn_save" @click.prevent="postponed">Save</button>
          </div>
      </div>
</modal>
</div>
</div>
</template>




<script>
  export default{
    props:['project'],
    data(){
       return{
         initialStage:1,
         definationStage:2,
         designStage:3,
         developStage:4,
         executeStage:5,
         closureStage:6,
         postponedStage:0,
         isSelected:this.project.stage,
           stagePop:false,
           reason:this.project.postponed

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
      initial(){
axios.patch('/api/project/'+this.project.id+'/stage',{
  stage:this.initialStage
}).then(response=>{
  this.isSelected=1;
     this.$vToastify.success("Project Converted to Initial Successfully");
}).catch(error=>{
  this.isSelected=this.project.stage;
  this.$vToastify.error("Error in Project Phase Conversion");
});
},

defination(){
  axios.patch('/api/project/'+this.project.id+'/stage',{
    stage:this.definationStage
  }).then(response=>{
    this.isSelected=2;
       this.$vToastify.success("Project Stage Converted to Defination");
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},

design(){
  axios.patch('/api/project/'+this.project.id+'/stage',{
    stage:this.designStage
  }).then(response=>{
    this.isSelected=3;
       this.$vToastify.success("Project Converted to Design Phase");
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},

develop(){
  axios.patch('/api/project/'+this.project.id+'/stage',{
    stage:this.developStage
  }).then(response=>{
    this.isSelected=4;
       this.$vToastify.success("Project Converted to Developing Phase");
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},

execute(){
  axios.patch('/api/project/'+this.project.id+'/stage',{
    stage:this.executeStage
  }).then(response=>{
    this.isSelected=5;
       this.$vToastify.success("Project Converted to Execution Stage");
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},

postponed(){
  axios.patch('/api/project/'+this.project.id+'/postponed',{
    stage:this.postponedStage,
    postponed:this.reason
  }).then(response=>{
    this.isSelected = 0;
       this.$vToastify.success("Project Postponed Successfully");
       this.$modal.hide('stage-reason');
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},
projectClosure(){
  axios.patch('/api/project/'+this.project.id+'/stage',{
    stage:this.closureStage
  }).then(response=>{
    this.isSelected=6;
       this.$vToastify.success("Project Phase Conerted to Closure");
  }).catch(error=>{
    this.isSelected=this.project.stage;
    this.$vToastify.error("Error in Project Phase Conversion");
  });
},
offIfClickedOutside(event){
    if(!event.target.closest('.stage-dropdown')){
        this.stagePop=false;
        document.removeEventListener('click',this.offIfClickedOutside);
    }
},
    }
  }
</script>

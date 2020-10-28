<template>
<div class="">
  <div class="row">
    <div class="arrow-pointer-pd" @click="initial">
      <p class="arrow-pointer-unq unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">1. New Stage</span></p>
      <p class="arrow-pointer-select" v-if="isSelected > 0"><span class="arrow-pointer-span">1. New Stage</span></p>

    </div>
     <div class="arrow-pointer-pd" @click="contact">
       <p class="arrow-pointer-unq unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">2. Contacted</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 1"><span class="arrow-pointer-span">2. Contacted</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">2. Contacted</span></p>
    </div>
     <div class="arrow-pointer-pd" @click="interest">
       <p class="arrow-pointer-unq unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">3. Interested</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 2"><span class="arrow-pointer-span">3. Interested</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">3. Interested</span></p>
    </div>
     <div class="arrow-pointer-pd" @click="review">
       <p class="arrow-pointer-unq unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">4. Reviewed</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 3"><span class="arrow-pointer-span">4. Reviewed</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">4. Reviewed</span></p>
    </div>
     <div class="arrow-pointer-pd" @click="demo">
       <p class="arrow-pointer-unq unq-bg" v-if="isSelected == 0"><span class="arrow-pointer-span">5. Exhibited</span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 4"><span class="arrow-pointer-span">5. Exhibited</span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span">5. Exhibited</span></p>
    </div>
     <div class="stage-dropdown" @click="stagePop = !stagePop">
       <p class="arrow-pointer-unq" v-if="isSelected == 0"><span class="arrow-pointer-span">Con/Unq <i class="fas fa-sort-down"></i></span></p>
       <p class="arrow-pointer-select" v-else-if="isSelected > 5"><span class="arrow-pointer-span">Con/Unq <i class="fas fa-sort-down"></i></span></p>
       <p class="arrow-pointer" v-else><span class="arrow-pointer-span pr-2">Con./Unq <i class="fas fa-sort-down"></i></span></p>
       <div class="stage-dropdown_item" v-show=stagePop>
         <ul>
           <li class="stage-dropdown_item-content">Convert</li>
           <li class="stage-dropdown_item-content" @click="$modal.show('stage-reason')">Unqualified</li>
         </ul>

       </div>
    </div>
  </div>
  <modal name="stage-reason" :clickToClose=false>
    <div class="panel-top_content">
        <span class="panel-heading">Lead Satge Unqualifed</span>
        <span class="panel-exit float-right" role="button" @click.prevent="$modal.hide('stage-reason')">x</span>

    </div>
    <hr>
      <div class="panel-top_content">
        <div class="form-group">
           <label for="unqstage" class="label-name">Reason of lead to be Unqualifed:</label>
          <select class="custom-select" id="unqstage" name="unqstage" v-model="reason" title="Some placeholder text...">
            <option value="Junk Lead">Junk Lead</option>
            <option value="Unable to reach">Unable to reach</option>
            <option value="Not intrested">Not intrested</option>
          </select>
        </div>


      </div>
      <div class="panel-bottom">
          <div class="panel-top_content float-right">
              <button class="btn panel-btn_close" @click.prevent="$modal.hide('stage-reason')">Cancel</button>
              <button class="btn panel-btn_save" @click.prevent="unqualifed">Save</button>
          </div>
      </div>
</modal>
</div>

  </template>




<script>
  export default{
    props:['lead'],
    data(){
       return{
         initialStage:1,
         contactStage:2,
         interestStage:3,
         reviewStage:4,
         demoStage:5,
         unqualifedStage:0,
         isSelected:this.lead.stage,
           stagePop:false,
           reason:this.lead.unqualifed

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
axios.patch('/api/lead/'+this.lead.id+'/stage',{
  stage:this.initialStage
}).then(response=>{
  this.isSelected=1;
     this.$vToastify.success("Lead Converted to Initial Successfully");
}).catch(error=>{
  this.isSelected=this.lead.stage;
  this.$vToastify.error("Error in Lead Conversion");
});
},

contact(){
  axios.patch('/api/lead/'+this.lead.id+'/stage',{
    stage:this.contactStage
  }).then(response=>{
    this.isSelected=2;
       this.$vToastify.success("Lead Converted to Contact Successfully");
  }).catch(error=>{
    this.isSelected=this.lead.stage;
    this.$vToastify.error("Error in Lead Conversion");
  });
},

interest(){
  axios.patch('/api/lead/'+this.lead.id+'/stage',{
    stage:this.interestStage
  }).then(response=>{
    this.isSelected=3;
       this.$vToastify.success("Lead Converted to Interest Successfully");
  }).catch(error=>{
    this.isSelected=this.lead.stage;
    this.$vToastify.error("Error in Lead Conversion");
  });
},

review(){
  axios.patch('/api/lead/'+this.lead.id+'/stage',{
    stage:this.reviewStage
  }).then(response=>{
    this.isSelected=4;
       this.$vToastify.success("Lead Converted to Review Successfully");
  }).catch(error=>{
    this.isSelected=this.lead.stage;
    this.$vToastify.error("Error in Lead Conversion");
  });
},

demo(){
  axios.patch('/api/lead/'+this.lead.id+'/stage',{
    stage:this.demoStage
  }).then(response=>{
    this.isSelected=5;
       this.$vToastify.success("Lead Converted to Demo Successfully");
  }).catch(error=>{
    this.isSelected=this.lead.stage;
    this.$vToastify.error("Error in Lead Conversion");
  });
},

unqualifed(){
  axios.patch('/api/lead/'+this.lead.id+'/unqualifed',{
    stage:this.unqualifedStage,
    unqualifed:this.reason
  }).then(response=>{
    this.isSelected = 0;
       this.$vToastify.success("Lead Unqualified Successfully");
       this.$modal.hide('stage-reason');
  }).catch(error=>{
    this.isSelected=this.lead.stage;
    this.$vToastify.error("Error in Lead Conversion");
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

<template>
<div>
  <div>
    <div>
  <p><span><b>Project Stage Last Updated:</b> {{ stageUpdated }}</span></p>
    </div>
  <div class="row" v-if="access">
  <ul class="d-flex flex-wrap ml-2 list-unstyled m-0 p-0 w-100">
    <li
      v-for="stage in stages"
      :key="stage.id"
      class="arrow-pointer-pd me-3"
      @click="handleStageClick(stage)"
    >
      <p :class="getStageClass(stage)" class="arrow-pointer">
        <span class="arrow-pointer-span">{{ stage.id }}. {{ stage.name }}</span>
      </p>
    </li>
  </ul>
</div>
  <div v-else>
    <h5>Only project members and owners are allowed to change the project stage.</h5>
  </div>
</div>
<div>
  <modal
name="stage-reason" :click-to-close=false 
    :height="260"
     :adaptive="true">
    <div class="panel-top_content">

        <span class="panel-heading">Project Satge Postponed</span>

        <span 
        class="panel-exit float-right" 
        role="button" 
        @click.prevent="$modal.hide('stage-reason')">
        x
      </span>
    </div>
      <div class="panel-top_content">
        <div class="form-group">
           <label for="unqstage" class="label-name">Reason of project to be Postponed:</label>
           <input type="text" class="form-control" name="unqstage" id="unqstage" v-model="reason">
        </div>
      </div>
          <div class="panel-top_content float-right">
              <button class="btn panel-btn_close" @click.prevent="$modal.hide('stage-reason')">Cancel</button>
             <button class="btn panel-btn_save" @click.prevent="postpone">Save</button>
          </div>
</modal>
</div>
</div>
</template>

<script>
  import { mapMutations } from 'vuex';

  export default{
    props:{
      slug: {
        type: String,
        default: '',
      },
      stageUpdated: {
        type: String,
        default: '',
      },
      postponedReason: {
        type: String,
        default: '',
      },
      getStage: {
        type: Number,
        default: 0,
      },
      access: {
        type: Boolean,
        default: false,
      },
    },
    data(){
       return{
         reason: this.postponedReason || '',
         stages:[],
         selectedStage:0,
       }
    },
    watch: {
      postponedReason(newValue) {
        this.reason = newValue || '';
      },
    },
    mounted(){
      this.loadStages();
    },
    methods:{
      ...mapMutations('project',['updateStage']),

  getStageClass(stage) {
  if (this.getStage === stage.id) {
    if (stage.name === "Postponed") return "postpone";
    if (stage.name === "Completed") return "closed";
    return "current";
  }
  return "stages";
 },

    handleStageClick(stage) {
      if (stage.name === "Postponed") {
        this.selectedStage=stage.id;
        this.$modal.show("stage-reason"); 
      } else {
        this.stageChange(stage.id); 
      }
    },

  updateProject(data) {
    if (!this.slug) {
      return;
    }
    this.$Progress.start();
  axios.patch(`/api/v1/projects/${this.slug}/stage`, data)

    .then(response => {
      this.$Progress.finish();
      const project = response.data.project;

      let eventData = {
        current_stage: project.stage || null,
        stage_updated: project.stage_updated_at,
        postponed_reason: project.postponed_reason || null,
        getStage: project.stage ? project.stage.id : 0
      };
      this.updateStage(eventData);
      this.$vToastify.success("Successfully update");
    })
    .catch(() => {
      this.$Progress.fail();
      this.$vToastify.error("Error in Project Phase Conversion");
    });
    this.selectedStage=0;
},  

  stageChange(stageId) {
  if (stageId === this.getStage) {
    return this.$vToastify.error("Stage already selected");
  }

  this.updateProject({ stage: stageId });
},
      
 postpone() {
  this.updateProject({stage:this.selectedStage, postponed_reason: this.reason });
   this.$modal.hide('stage-reason');
},


 loadStages(){
    axios.get('/api/v1/stages').
    then(response=>{
       this.stages=response.data;
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},
  },
  }
</script>

<template>
<div>
		<modal name="MeetingModal" height="auto" :scrollable="true" width="40%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3">

    <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="panel-heading">Create A New Project Meeting</span>
            <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
        </div>
    </div>
    
        <div class="panel-form">
<form class="" @submit.prevent="createMeeting()">
  <div class="panel-top_content">

    <FormGroup id="topic" label="Topic:" :error="errors.topic">
        <input type="text" id="topic" class="form-control" name="topic" v-model="form.topic" placeholder="Title for meeting">
    </FormGroup>

    <FormGroup id="agenda" label="Agenda:" :error="errors.agenda">
        <textarea name="agenda" class="form-control" rows="3" v-model="form.agenda" placeholder="Enter meeting agenda here"></textarea>
    </FormGroup>

    <FormGroup id="password" label="Password:" :error="errors.password">
        <input type="password" id="password" class="form-control" name="password" v-model="form.password" place="Enter unique meeting passcode">
    </FormGroup>

	<FormGroup id="join_before_host" label="Join Before Host:" :error="errors.join_before_host">

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinBefore" name="join_before_host" value="true" v-model="form.join_before_host">
    <label class="form-check-label" for="join_before">Yes</label>
  </div>

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinAfter" name="join_before_host" value="false" v-model="form.join_before_host">
    <label class="form-check-label" for="joinAfter">No</label>
  </div>
  </FormGroup>


  <FormGroup id="duration" label="Duration:" :error=" errors.duration">
   <select id="duration" v-model="form.duration" class="form-control">
  	   <option value="" disabled selected>Select Meeting Duration</option>
     <option value="15">15 minutes</option>
     <option value="30">30 minutes</option>
     <option value="45">45 minutes</option>
   </select>
 </FormGroup>

  <FormGroup id="start_time" label="Start Time:" :error="errors.start_time">
  <datetime type="datetime" v-model="form.start_time" value-zone="local" zone="local"></datetime>
 </FormGroup>

  </div>

  <div class="panel-bottom">
		<div class="panel-top_content float-left">
		</div>
      <div class="panel-top_content float-right">
          <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
          <button class="btn panel-btn_save" type="submit" :disabled="loading">{{ loading ? 'Creating...' : 'Create' }}</button>
      </div>
  </div>
</form>
        </div>
  </div>
    </modal>
</div>

</template>


<script>
  import { mapState, mapMutations, mapActions } from 'vuex';
  import FormGroup from './../FormGroup.vue';

export default{
  components: { FormGroup },

	props:['projectSlug'],

    data() {	
     return{
	     form:{
    	 topic:'',
    	 agenda:'',
    	 join_before_host:'',
    	 duration:'',
    	 start_time:'',
    	 timezone:'UTC',
     },
     errors:{},
     loading:false,
      loaderId: null,
     };
     },

    mounted() {
    this.$bus.on('open-meeting-modal', 
            this.openMeetingModal);
    },
  
   destroyed() {
     this.$bus.off('open-meeting-modal', 
               this.openMeetingModal);
    },

    methods:{

      ...mapMutations('meeting', ['addMeeting']),

    	createMeeting()
      {
        this.initializeMeetingCreation();

      axios.post(`/api/v1/projects/${this.projectSlug}/meetings`,this.form)
        .then(response => {
          this.$bus.emit('get-results');
          this.$vToastify.success(response.data.message);
          this.modalClose();
        })
        .catch(error => {
          this.handleErrorResponse(error);
      }).finally(() => {
          this.$vToastify.stopLoader(this.loaderId);
          this.loading = false;
      });
    },

    initializeMeetingCreation(){
      this.booleanJoinBeforeHost();

      this.loaderId = this.$vToastify.loader('Creating meeting, please wait...');

        this.loading = true;

        this.errors= {};
    },

    booleanJoinBeforeHost(){
      return this.form.join_before_host = this.form.join_before_host === 'true';
    },

     openMeetingModal() {
      this.$modal.show('MeetingModal');
    },

    modalClose(){
      this.$modal.hide('MeetingModal');
      this.errors={};
      this.form = Object.assign({}, this.$options.data().form);
    },
    
}
}
</script>
	
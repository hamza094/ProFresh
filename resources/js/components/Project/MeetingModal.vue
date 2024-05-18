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

    <div class="form-group">
        <label for="topic" class="label-name">Topic:</label>
        <input type="text" id="topic" class="form-control" name="topic" v-model="form.topic" placeholder="Title for meeting">
				<p class="text-danger" v-if="this.errors">*{{this.errors}}</p>
    </div>
    <div class="form-group">
        <label for="agenda" class="label-name">Agenda:</label>
        <textarea name="agenda" class="form-control" rows="3" v-model="form.agenda" placeholder="Enter meeting agenda here"></textarea>
				<p class="text-danger" v-if="this.errors">*{{this.errors}}</p>
    </div>

    <div class="form-group">
        <label for="password" class="label-name">Password:</label>
        <input type="password" id="password" class="form-control" name="password" v-model="form.password" place="Enter unique meeting passcode">
				<p class="text-danger" v-if="this.errors">*{{this.errors}}</p>
    </div>

		<div class="form-group">
  <p><b>Join Befor Host:</b></p>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinBefore" name="joinBeforeHost" value="true" v-model="form.joinBeforeHost">
    <label class="form-check-label" for="joinBefore">Yes</label>
  </div>

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinAfter" name="joinBeforeHost" value="false" v-model="form.joinBeforeHost">
    <label class="form-check-label" for="joinAfter">No</label>
  </div>
  <p class="text-danger" v-if="this.errors"></p>
</div>

<div class="form-group">
  <label for="duration"><b>Duration:</b></label>
  <select id="duration" v-model="form.duration" class="form-control">
  	  <option value="" disabled selected>Select Meeting Duration</option>
    <option value="15">15 minutes</option>
    <option value="30">30 minutes</option>
    <option value="45">45 minutes</option>
  </select>
</div>
<div class="form-group">
  <label for="strttm"><b>Start Time:</b></label>
  <datetime type="datetime" v-model="form.strttm" value-zone="local" zone="local"></datetime>
</div>
  </div>

  <div class="panel-bottom">
		<div class="panel-top_content float-left">
		</div>
      <div class="panel-top_content float-right">
          <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
          <button class="btn panel-btn_save" type="submit">Create</button>
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

export default{
	props:['projectSlug'],
	  components:{
	  
	  },

    data(){	
    return{
	form:{
    	topic:'',
    	agenda:'',
    	joinBeforeHost:'',
    	duration:'',
    	strttm:'',
    	timezone:''
    },
    errors:[],
    };
    },
    mounted() {
    this.$bus.on('open-meeting-modal', () => {
      this.$modal.show('MeetingModal');
    });
  },
  destroyed() {
    this.$bus.$off('open-meeting-modal');
  },

    methods:{
        ...mapMutations('meeting', ['addMeeting']), 
    	createMeeting() {
      // Send the form data object with Axios
      axios.post(`/api/v1/projects/${this.projectSlug}/zoom/meeting/create`,this.form)
        .then(response => {
          this.addMeeting(response.data.meeting);
        this.$bus.emit('get-results');
        })
        .catch(error => {
          console.error(error);
        });
    },
    meetingModal(){
     this.$modal.show('MeetingModal');
    },
    modalClose(){
      this.$modal.hide('MeetingModal');
      this.form = Object.assign({}, this.$options.data().form);
    },
    
}
}
</script>
	
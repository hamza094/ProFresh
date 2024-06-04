<template>
	<div>
<div class="project-info">
		<div class="project-info_socre">
			<p class="project-info_score-heading">Meetings</p>
				<p v-if="notAuthorize" class="btn btn-sm btn-secondary" @click.prevent="authorize">Authorize With Zoom</p>
				<button v-if="!notAuthorize" class="btn btn-sm btn-primary" @click.pervent="openMeetingModal()">Create Meating</button>
					</div>
					<hr>
      <div class="btn-group" role="group">
      <button
        type="button"
        class="btn btn-link btn-sm meeting_button"
        :class="{ active: !showPrevious }"
        @click="showCurrentMeetings"
      >
        Current Meetings
      </button>
      <button
        type="button"
        class="btn btn-link btn-sm meeting_button"
        :class="{ active: showPrevious }"
        @click="showPreviousMeetings"
      >
        Previous Meetings
      </button>
    </div>
      <div v-if="message" class="alert alert-info">
      {{ message }}
    </div>
				<div v-for="(meeting,index) in meetings.data" :key="meeting.id">
                <div class="card mt-3 card-hover" @click.pervent="getMeeting(meeting.id)">
                	<div class="ribbon bg-red">{{meeting.status}}</div>
                  <div class="card-stamp">
                    <div class="card-stamp-icon bg-yellow">
                      <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                    </div>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">{{meeting.topic}}</h3>
                    <p class="text-secondary">{{meeting.agenda}}</p>
                    <p>
                    		<b>Start Time:</b>  {{meeting.start_time}}
                    	</p>
                      <p>
                    		<b>Timezone:</b> 
                    		{{meeting.timezone}}
                    </p>
                    <p><b>Created At:</b> {{meeting.created_at}}</p>
                  </div>
                </div>
              </div>
		</div>
	<pagination :data="meetings" @pagination-change-page="getResults"></pagination>

  <MeetingModal :projectSlug="this.projectSlug"></MeetingModal>

  <modal name="ViewMeeting" height="auto" :scrollable="true" width="40%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3">
     <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="meeting_heading">{{meeting.topic}}</span>
        <div v-if="isEditing" class="form-group row">
          <div class="col-md-9">
          <input class="form-control" v-model="form.topic" placeholder="Edit meeting title">
        </div>
      </div>
        <span v-if="!isEditing" class="panel-exit float-right" role="button" @click.prevent="meetingModalClose">x</span>
        </div>
    </div>
    <div v-if="meeting" class="meeting">
    <ul class="meeting_list">
        <li v-if="!isEditing">
        	<b>Meeting id: </b> 
          <span class="meeting_item">{{meeting.meeting_id}}</span>
        </li>
        <li>
        	<b>Agenda: </b>
           <span v-if="!isEditing" class="meeting_item meeting-agenda">{{meeting.agenda}}
           <span class="text-danger font-italic" v-if="errors.agenda" v-text="errors.agenda"></span> 
           </span>
           <textarea v-else class="form-control" v-model="form.agenda"></textarea>
        </li>
        <li>
        	<b>Start Time: </b> 
          <span class="meeting_item">{{meeting.start_time}}</span>
          <br>
          <span class="text-danger font-italic" v-if="errors.start_time" v-text="errors.start_time[0]"></span>
          <div v-if="isEditing" class="form-group" v-else>
            <div class="col-md-6">
  <datetime type="datetime" :value="meeting.start_time" v-model="form.start_time" value-zone="local" zone="local"
   format="YYYY-MM-DD HH:mm:ss"></datetime>
</div>
</div>
        </li>
        <li>
        	<b>Meeting Duration: </b> <span  class="meeting_item">{{meeting.duration}} Minutes</span>
          <br>
          <span class="text-danger font-italic" v-if="errors.duration" v-text="errors.duration[0]"></span>

      <div class="form-group row" v-if="isEditing">
  <div class="col-md-6">
    <select id="duration" class="form-control" v-model="form.duration">
      <option value="" disabled selected>Select Meeting Duration</option>
      <option value="15">15 minutes</option>
      <option value="30">30 minutes</option>
      <option value="45">45 minutes</option>
    </select>
  </div>
</div>
        </li>
        <li v-if="!isEditing">
        	<b>Status: </b> <span class="meeting_item">{{meeting.status}}</span>
        </li>
        <li v-if="!isEditing">
        	<b>Start Url: </b><span v-if="meeting" class="btn btn-secondary btn-sm">Start Meeting As Owner</span>
        </li>
        <li v-if="!isEditing">
        	<b>Join Url: </b><span v-if="meeting" class="btn btn-secondary btn-sm">Join Meeting As Guest</span>
        </li>
        <li v-if="!isEditing && meeting.owner">
          <b>Created By: </b> <span class="meeting_item">{{meeting.owner.name}}</span>
        </li>
        	<li v-if="!isEditing">
            <b>Created At: </b> <span class="meeting_item">{{meeting.created_at}}</span>
          </li>
        <li>
        	<b>Timezone: </b> <span class="meeting_item">{{meeting.timezone}}</span>
          <br>
          <span class="text-danger font-italic" v-if="errors.timezone" v-text="errors.timezone[0]"></span>
          <div v-if="isEditing"  class="form-group row">
    <div class="col-md-6">
      <input class="form-control" v-model="form.timezone">
    </div>
  </div>
        </li>
        <li>
        	<b>Password: </b> <span class="meeting_item">{{meeting.password}}</span>
           <br>
          <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
          <div v-if="isEditing" class="form-group row">
          <div class="col-md-6">
           <input class="form-control" v-model="form.password">
          </div>
      </div>

        </li>
        <li v-if="!isEditing">
          <b>Updated At: </b> <span class="meeting_item">{{meeting.updated_at}}</span>
        </li>
        <li>
        	<b>Join Before Host: </b> <span class="meeting_item">{{meeting.join_before_host}}</span>
           <br>
          <span class="text-danger font-italic" v-if="errors.join_before_host" v-text="errors.join_before_host[0]"></span>
            <div v-if="isEditing" class="form-group" v-else>
  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinBefore" name="joinBeforeHost" :value="true" v-model="form.join_before_host">
    <label class="form-check-label" for="joinBefore">Yes</label>
  </div>

  <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" id="joinAfter" name="joinBeforeHost" :value="false" v-model="form.join_before_host">
    <label class="form-check-label" for="joinAfter">No</label>
  </div>
</div>
        </li>
        <li  v-if="!isEditing">
        	<b>Get zak token: </b><button v-if="meeting" class="btn btn-sm btn-secondary">Get Token</button>
        </li>
    </ul>
    <div v-if="!isEditing">
    <button class="btn btn-danger float-right mb-3" @click.pervent="deleteMeeting(meeting.id)">Delete</button>
    <button class="btn btn-primary float-left mb-3" @click.pervent="meetingEdit()">Edit</button>
  </div>
  <div v-if="isEditing">
    <button class="btn btn-info float-right mb-3" @click.pervent="meetingEditClose()">Close</button>
    <button class="btn btn-primary float-left mb-3" @click.pervent="updateMeeting(meeting.id)">Save</button>
  </div>
</div>
    </div>

</modal> 
</div>
</template>	

<script>
	import MeetingModal from './MeetingModal.vue'
  import { permission } from '../../auth'
  import { mapState, mapMutations, mapActions } from 'vuex';

export default{
	props:['projectSlug','projectMeetings','notAuthorize'],
	  components:{
	  	MeetingModal
	  },

    data(){	
    return{
		meeting:[],
        showPrevious: false,
        updateForm:{
          meeting_id:82494622387,
          agenda:'the is thunder of lightining bolt'
        },
        isEditing: false,
        errors:{},
        form:{
          meeting_id:'',
          topic:'',
          agenda:'',
          start_time:'',
          duration:'',
          join_before_host:'',
          timezone:'',
          password:'',
        }
    };
    },
    computed:{
    ...mapState('meeting',['meetings','message']),
  },

    methods:{ 
    	...mapActions({
      fetchMeetings: 'meeting/fetchMeetings',
    }),
    ...mapMutations('meeting', {
      updateMeetingInState: 'meetingUpdate',
      removeMeetingFromState: 'removeMeetingFromState',
    }),
     filterForm() {
      return Object.fromEntries(Object.entries(this.form).filter(([key, value]) => value !== null && value !== ''));
    },
    deleteMeeting(meeting){
     axios.delete(`/api/v1/projects/${this.projectSlug}/meetings/${meeting}/delete`)
        .then(response => {
           this.removeMeetingFromState(meeting);
           this.$vToastify.success(response.data.message);
           this.meetingModalClose();
        })
        .catch(error => {
          console.error(error);
        });
    },

    getResults(page) {
        const slug = this.$route.params.slug;
        this.fetchMeetings({ slug, page, isPrevious: this.showPrevious });
    },
    showCurrentMeetings() {
      this.showPrevious = false;
      this.getResults();
    },
    updateMeeting(id){
      this.form.meeting_id=this.meeting.meeting_id;

       if (this.form.start_time) {
      this.form.start_time = new Date(this.form.start_time).toISOString(); // Ensure ISO format
    }

      const filteredForm = Object.fromEntries(
      Object.entries(this.form).filter(([key, value]) => value !== null && value !== '')
    );

      axios.put(`/api/v1/projects/${this.projectSlug}/meetings/${id}/update`,filteredForm)
        .then(response => {
          this.meeting=response.data.meeting;
          this.updateMeetingInState(response.data.meeting);
          this.$vToastify.success(response.data.message);
          this.meetingEditClose();
        })
        .catch(error => {
          this.errors=error.response.data.errors;
        });
    },
    showPreviousMeetings() {
      this.showPrevious = true;
      this.getResults();
    },	
    openMeetingModal() {
      this.$bus.emit('open-meeting-modal');
    },
    getMeeting(meeting){
    	this.$modal.show('ViewMeeting');
    	axios.get(`/api/v1/projects/${this.projectSlug}/meetings/${meeting}`)
        .then(response => {
          this.meeting=response.data;
          this.form.agenda=this.meeting.agenda;
        })
        .catch(error => {
          console.error(error);
        });
    },
    meetingModalClose(){
           this.$modal.hide('ViewMeeting');
           this.meeting=[];
    },
    meetingEdit(){
      this.isEditing=true;
    },
    meetingEditClose(){
      this.isEditing=false;
      this.form={};
      this.errors={};
      this.form.agenda=this.meeting.agenda;
    },
    authorize(){
		axios.get(`/api/v1/oauth/zoom/redirect`,{
			}).then(response=>{
			   window.location.href = response.data.redirectUrl;
			}).catch(error=>{
	});
  },
},
created(){
     this.showCurrentMeetings();
  },
    mounted() {
    this.$bus.on('get-results', () => {
      this.showCurrentMeetings();
    });
  },
  destroyed() {
    this.$bus.$off('get-results');
  },
}
</script>

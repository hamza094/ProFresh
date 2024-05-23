<template>
	<div>
<div class="project-info">
		<div class="project-info_socre">
			<p class="project-info_score-heading">Meetings</p>
      <button class="btn btn-info" @click.prevent="UpdateMeeting">Update Meeting</button>
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
            <span class="panel-heading">{{meeting.topic}}</span>
            <span class="panel-exit float-right" role="button" @click.prevent="meetingModalClose">x</span>
        </div>
    </div>
    <div v-if="meeting" class="meeting">
    <ul class="meeting_list">
        <li>
        	<b>Meeting id: <span class="meeting_item">{{meeting.meeting_id}}</span></b>
        </li>
        <li>
        	<b>Agenda: <span class="meeting_item meeting-agenda">{{meeting.agenda}}</span></b>
        </li>
        <li>
        	<b>Start Time: <span class="meeting_item">{{meeting.start_time}}</span></b>
        </li>
        <li>
        	<b>Meeting Duration: <span class="meeting_item">{{meeting.duration}} Minutes</span></b>
        </li>
        <li>
        	<b>Status: <span class="meeting_item">{{meeting.status}}</span></b>
        </li>
        <li>
        	<b>Start Url: </b><span v-if="meeting" class="btn btn-secondary btn-sm">Start Meeting As Owner</span>
        </li>
        <li>
        	<b>Join Url: </b><span v-if="meeting" class="btn btn-secondary btn-sm">Join Meeting As Guest</span>
        </li>
        <li v-if="meeting.owner"><b>Created By: <span class="meeting_item">{{meeting.owner.name}}</span></b></li>
        <li>
        	<li v-if="meeting.owner"><b>Created At: <span class="meeting_item">{{meeting.created_at}}</span></b></li>
        <li>
        	<b>Timezone: <span class="meeting_item">{{meeting.timezone}}</span></b>
        </li>
        <li>
        	<b>Password: <span class="meeting_item">{{meeting.password}}</span></b>
        </li>
        <li>
        	<b>Join Before Host: <span class="meeting_item">{{meeting.join_before_host}}</span></b>
        </li>
        <li>
        	<b>Get zak token: </b><button v-if="meeting" class="btn btn-sm btn-secondary">Get Token</button>
        </li>
    </ul>
    <button class="btn btn-danger float-right mb-3">Delete</button>
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

    getResults(page) {
        const slug = this.$route.params.slug;
        this.fetchMeetings({ slug, page, isPrevious: this.showPrevious });
    },
    showCurrentMeetings() {
      this.showPrevious = false;
      this.getResults();
    },
    UpdateMeeting(){
      axios.post(`/api/v1/projects/${this.projectSlug}/meetings/1/update`,this.updateForm)
        .then(response => {
          this.meeting=response.data;
        })
        .catch(error => {
          console.error(error);
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
    	axios.get(`/api/v1/projects/${this.projectSlug}/meetings/${meeting}`,)
        .then(response => {
          this.meeting=response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    meetingModalClose(){
           this.$modal.hide('ViewMeeting');
           this.meeting=[];
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

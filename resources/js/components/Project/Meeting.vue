<template>
	<div>
      <div id="meetingSDKElement"></div>
<div class="project-info">
		<div class="project-info_socre">
			<p class="project-info_score-heading">Meetings</p>

				<p v-if="notAuthorize" class="btn btn-sm btn-secondary" @click.prevent="authorize">Authorize With Zoom</p>

				<button v-if="!notAuthorize" class="btn btn-sm btn-primary" @click.pervent="openMeetingModal()">Create Meating</button>

        <button class="btn btn-sm btn-warning" @click.pervent="check()">check</button>
        
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
                	<div :class="['ribbon', ribbonColor(meeting.status)]">{{meeting.status}}</div>
                  <div class="card-stamp">
                    <div class="card-stamp-icon bg-yellow">
                      <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path><path d="M9 17v1a3 3 0 0 0 6 0v-1"></path></svg>
                    </div>
                  </div>
                  <div v-if="meeting.status === 'Started'" class="glowing-dot"></div>
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
                <div class="card-footer">
                      <button v-if="canStartMeeting(meeting)" class="btn btn-sm btn-primary" @click.prevent="initializeMeting('start',meeting)">
                      Start Meeting
                    </button>
                      <button v-else-if="canJoinMeeting(meeting)"  class="btn btn-sm btn-warning text-white" @click.prevent="initializeMeting('join',meeting)"
                      >Join Meeting</button>
                  </div>
              </div>
		</div>
	<pagination :data="meetings" @pagination-change-page="getResults"></pagination>

  <MeetingModal :projectSlug="this.projectSlug"></MeetingModal>

  <ViewModal :projectSlug="this.projectSlug" :members="this.members" :notAuthorize="this.notAuthorize"></ViewModal>
 
</div>
</template>	

<script>
	import MeetingModal from './MeetingModal.vue'
    import ViewModal from './ViewModal.vue'
  import { permission } from '../../auth'
  import { mapState, mapMutations, mapActions } from 'vuex';
  import { fetchTokens, setupAndJoinMeeting } from '../../utils/zoomUtils';
  import { canStartMeeting, canJoinMeeting  } from '../../utils/meetingUtils';

export default{
	props:['projectSlug','projectMeetings','notAuthorize','members'],
	  components:{
	  	MeetingModal,
      ViewModal
	  },

    data(){	
    return{
        showPrevious: false,
        client: null,
        auth:this.$store.state.currentUser.user,
        loadingId:null,
    };
    },
    computed:{
    ...mapState('meeting',['meetings','message']),
  },

    methods:{ 
    	...mapActions({
      fetchMeetings: 'meeting/fetchMeetings',
    }),
    getMeeting(meetingId) {
      this.$bus.$emit('view-meeting-modal',meetingId);
    },
     canStartMeeting(meeting) {
      return canStartMeeting(meeting, this.auth, !this.notAuthorize);
    },
    canJoinMeeting(meeting) {
      return canJoinMeeting(meeting, this.auth, this.members);
    },
  
    getResults(page) {
      const slug = this.$route.params.slug;
      this.fetchMeetings({ slug, page, isPrevious: this.showPrevious });
    },
    showCurrentMeetings() {
      this.showPrevious = false;
      this.getResults();
    },
    
    showPreviousMeetings() {
      this.showPrevious = true;
      this.getResults();
    },	
    openMeetingModal() {
      this.$bus.emit('open-meeting-modal');
    },
    authorize(){
		axios.get(`/api/v1/oauth/zoom/redirect`,{
			}).then(response=>{
			   window.location.href = response.data.redirectUrl;
			}).catch(error=>{
	});
  },

   check(){
    axios.get(`/api/v1/webhooks/zoom/meetings/check`,{
      }).then(response=>{
         console.log(response);
      }).catch(error=>{
  });
  },

  async initializeMeting(action,meeting)
  {
    this.loadingId=this.$vToastify.loader('Initializing meeting. Please hold on...');

    try{
   const role = this.auth.id === meeting.owner.id ? 1 : 0;

  const [zakTokenResponse, jwtTokenResponse] = await fetchTokens(action, role, meeting.meeting_id,this.$vToastify);

    const zak_token = zakTokenResponse ? zakTokenResponse.zak_token : null;

    const jwt_token = jwtTokenResponse.jwt_token;

    await setupAndJoinMeeting(action, meeting, jwt_token, zak_token,this.auth);

    this.$vToastify.success('Meeting initiated successfully!');

    }catch(error){
      this.$vToastify.error('Meeting initiated failed!');
    } finally {
    this.$vToastify.stopLoader(this.loadingId);
    this.loadingId=null;
    }
  },
  ribbonColor(status) {
      switch (status.toLowerCase()) {
        case 'waiting':
          return 'bg-yellow';
        case 'started':
          return 'bg-green';
        default:
          return 'bg-red';
      }
    },
 },
created(){
     this.showCurrentMeetings();
     this.$bus.$on('initialize-meeting', this.initializeMeting);
  },
    mounted() {
    this.$bus.on('get-results', () => {
      this.showCurrentMeetings();
    });
  },
  destroyed() {
    this.$bus.$off('get-results');
    this.$bus.$off('initialize-meeting', this.initializeMeting);

  },
}
</script>

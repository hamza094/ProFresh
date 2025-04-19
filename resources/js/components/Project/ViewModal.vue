<template>
<div>
  <modal name="ViewMeeting" height="auto" :scrollable="true" width="40%"
     class="model-desin"
    :clickToClose=false >

    <div class="edit-border-top p-3">
      <div v-if="meeting.status === 'Started'" class="glowing-dot"></div>

     <div class="edit-border-bottom">

        <div class="panel-top_content">
            <span class="meeting_heading">{{meeting.topic}}</span>

        <div v-if="isEditing" class="form-group row">
          <div class="col-md-9">
          <input class="form-control" v-model="form.topic" placeholder="Edit meeting title">
          <span class="text-danger font-italic" v-if="errors.topic" v-text="errors.topic[0]"></span>
        </div>
      </div>

        <span v-if="!isEditing" class="panel-exit float-right" role="button" @click.prevent="meetingModalClose">x</span>
        </div>

    </div>
    <div v-if="meeting" class="meeting">
    <ul class="meeting_list">

    <meeting-detail v-if="!isEditing" label="Meeting ID" :value="meeting.meeting_id" />

    <meeting-detail label="Agenda" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.agenda }}</span>
      </template>

      <template v-else>
        <textarea class="form-control" v-model="form.agenda"></textarea>
      <span class="text-danger font-italic" v-if="errors.agenda" v-text="errors.agenda[0]"></span>
      </template>
    </meeting-detail>

    <meeting-detail label="Start Time" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.start_time }}</span>
      </template>

      <template v-else>
        <datetime type="datetime" :value="meeting.start_time" v-model="form.start_time" value-zone="local" zone="local" format="YYYY-MM-DD HH:mm:ss" />
        <span class="text-danger font-italic" v-if="errors.start_time" v-text="errors.start_time[0]"></span>
      </template>
    </meeting-detail>

    <meeting-detail label="Meeting Duration" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.duration }} Minutes</span>
      </template>

      <template v-else>
        <select id="duration" class="form-control" v-model="form.duration">
          <option value="" disabled selected>Select Meeting Duration</option>
          <option value="15">15 minutes</option>
          <option value="30">30 minutes</option>
          <option value="45">45 minutes</option>
        </select>
        <span class="text-danger font-italic" v-if="errors.duration" v-text="errors.duration[0]"></span>
      </template>
    </meeting-detail>

    <meeting-detail v-if="!isEditing" label="Status" :value="meeting.status"/>

    <meeting-detail v-if="!isEditing && meeting.owner" label="Created By" :value="meeting.owner.name" />

    <meeting-detail v-if="!isEditing" label="Created At" :value="meeting.created_at" />

     <meeting-detail label="Timezone" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.timezone }}</span>
      </template>

      <template v-else>
        <input class="form-control" v-model="form.timezone" />
        <span class="text-danger font-italic" v-if="errors.timezone" v-text="errors.timezone[0]"></span>
      </template>

    </meeting-detail>


    <meeting-detail label="Password" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.password }}</span>
      </template>

      <template v-else>
        <input class="form-control" v-model="form.password" />
        <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
        </template>
      </meeting-detail>

      <meeting-detail v-if="!isEditing" label="Updated At" :value="meeting.updated_at" />

    <meeting-detail label="Join Before Host" :isEditing="isEditing">
      <template v-if="!isEditing">
        <span>{{ meeting.join_before_host }}</span>
      </template>

       <template v-else>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="joinBefore" name="joinBeforeHost" :value="true" v-model="form.join_before_host" />
          <label class="form-check-label" for="joinBefore">Yes</label>
          </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" id="joinAfter" name="joinBeforeHost" :value="false" v-model="form.join_before_host" />
           <label class="form-check-label" for="joinAfter">No</label>
        </div>
        <br>
          <span class="text-danger font-italic" v-if="errors.join_before_host" v-text="errors.join_before_host[0]"></span>
          <br>
        </template>
      </meeting-detail>

       <li v-if="!isEditing && Object.keys(meeting).length > 0">
          <button v-if="canStartMeeting(meeting)" class="btn btn-secondary btn-sm" @click.prevent="emitInitializeMeting('start',meeting)">Start Meeting As Owner</button>
        
          <button v-else-if="canJoinMeeting(meeting)" class="btn btn-secondary btn-sm" @click.prevent="emitInitializeMeting('join',meeting)">Join Meeting</button>

        </li>

    </ul>

    <div v-if="Object.keys(meeting).length > 0" class="mt-3">
    <div v-if="!isEditing">
    <button class="btn btn-danger float-right mb-3" @click.pervent="deleteMeeting(meeting.id)" :disabled="loader">{{ loader ? 'Deleting...' : 'Delete' }}</button>
    <button class="btn btn-primary float-left mb-3" @click.pervent="meetingEdit()">Edit</button>
  </div>

  <div v-else>
    <button class="btn btn-info float-right mb-3" @click.pervent="meetingEditClose()">Close</button>
    <button class="btn btn-primary float-left mb-3" @click.pervent="updateMeeting(meeting.id)" :disabled="loading">{{ loading ? 'Saving...' : 'Save' }}</button>
  </div>
</div>

</div>
    </div>

</modal>
</div>

</template>


<script>
  import { mapState, mapMutations, mapActions } from 'vuex';
  import MeetingDetail from './MeetingDetail.vue';
  import { shouldShowStartButton, shouldShowJoinButton  } from '../../utils/meetingUtils';

export default{
  components: {
    MeetingDetail
  },

	props:['projectSlug','notAuthorize','members'],

    data() {	
     return{
      meeting:[],
        isEditing: false,
        errors:{},
        loader:false,
        loading:false,
        loaderId: null,
        auth:this.$store.state.currentUser.user,
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

   created(){
    this.$bus.$on('view-meeting-modal', this.getMeeting);
    },

    beforeDestroy(){
     this.$bus.$off('view-meeting-modal', this.getMeeting);
    },

    methods:{
      ...mapMutations('meeting', {
      updateMeetingInState: 'meetingUpdate',
      removeMeetingFromState: 'removeMeetingFromState',
    }),

    emitInitializeMeting(action, meeting) {
      this.$bus.$emit('initialize-meeting', action, meeting);
      this.meetingModalClose();
    },

    canStartMeeting(meeting) {
      return shouldShowStartButton(meeting, this.auth, !this.notAuthorize);
    },

    canJoinMeeting(meeting) {
      return shouldShowJoinButton(meeting, this.auth, this.members);
    },

    updateMeeting(id){
      this.initiliazeUpdateMeeting();

      const filteredForm = this.filterForm();

      axios.patch(`/api/v1/projects/${this.projectSlug}/meetings/${id}`,filteredForm)
        .then(response => {
          this.meeting=response.data.meeting;
          this.updateMeetingInState(this.meeting);
          this.$vToastify.success(response.data.message);
          this.meetingEditClose();
        })
        .catch(error => {
          this.handleErrorResponse(error);
        }).finally(() => {
          this.setLoading('', 'stop');
          this.loading=false;
      });
    },

    deleteMeeting(meeting){
      this.setLoading('Deleting meeting, please wait...', 'start');

      this.loader = true;

     axios.delete(`/api/v1/projects/${this.projectSlug}/meetings/${meeting}`)
        .then(response => {
          this.meetingModalClose();
          this.removeMeetingFromState(meeting);
          this.$vToastify.success(response.data.message);
        })
        .catch(error => {
          this.$vToastify.error('Meeting deletion failed');
        }).finally(() => {
          this.setLoading('', 'stop');
          this.loader=false;
      });
    },

    getMeeting(meetingId){
      this.$modal.show('ViewMeeting');
      axios.get(`/api/v1/projects/${this.projectSlug}/meetings/${meetingId}`)
        .then(response => {
          this.meeting=response.data;
          this.form.agenda=this.meeting.agenda;
        })
        .catch(error => {
          this.$vToastify.error('Meeting Loading failed');
        });
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

    meetingModalClose(){
           this.$modal.hide('ViewMeeting');
           this.meeting=[];
    },

    filterForm() {
      return Object.fromEntries(Object.entries(this.form).filter(([key, value]) => value !== null && value !== ''));
    },

    initiliazeUpdateMeeting()
    {
      this.form.meeting_id=this.meeting.meeting_id;
      this.form.start_time = this.convertToISO(this.form.start_time);
      this.errors = {};
      this.loading = true;
     this.setLoading('Updating meeting, please wait...', 'start');
    },

    setLoading(message, action) {
      if (action === 'start') {
        this.loaderId = this.$vToastify.loader(message);
      } else {
        this.$vToastify.stopLoader(this.loaderId);
        this.loaderId = null;
      }
    },

    convertToISO(date){
       return date ? new Date(date).toISOString() : date;
    },  	
}
}
</script>
	
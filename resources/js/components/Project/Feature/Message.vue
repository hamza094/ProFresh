<template>
	<div>
		<!-- Message Modal-->
	    <modal name="project-message" height="auto" :scrollable="true" width="45%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3">

    <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="panel-heading">Send message to members</span>
            <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
        </div>
    </div>
        <SubscriptionCheck>
        <div class="panel-form">
<form class="" @submit.prevent="sendMessage()">
  <div class="panel-top_content">

    <div class="form-group">
        <label for="message" class="label-name">Subject:</label>
        <input type="text" id="subject" class="form-control" name="subject" v-model="form.subject" :readonly="!this.form.mail">
				<p class="text-danger" v-if="this.errors.subject">*{{this.errors.subject[0]}}</p>
    </div>

    <div class="form-group">
        <label for="subject" class="label-name">Message:</label>
        <textarea name="message" class="form-control" rows="5" v-model="form.message"></textarea>
				<p class="text-danger" v-if="this.errors.message">*{{this.errors.message[0]}}</p>
    </div>

		<div class="form-group">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="mailCheckbox" name="mail" v-model="form.mail">
			<label class="form-check-label" for="mailCheckbox">Send Mail</label>
		</div>

		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="smsCheckbox" name="sms" v-model="form.sms">
			<label class="form-check-label" for="smsCheckbox">Send Sms</label>
		</div>
		<p class="text-danger" v-if="this.errors.option">*{{this.errors.option[0]}}</p>
	</div>

	<div class="form-group">
		<label for="to" class="label-name mt-2">To: Select Project Member</label>
		<div class="check_members">
		<div class="form-check" v-for="(user,index) in  this.members" :key="user.id">
	<input v-if="user.id !== auth.id" class="form-check-input" type="checkbox" v-model="form.users" :value="user" id="checkUsers">
	<label v-if="user.id !== auth.id" class="form-check-label" for="checkUsers">
		{{user.name}} ({{user.email}})
	</label>
</div>
</div>
<p class="text-danger" v-if="this.errors.users">*{{this.errors.users[0]}}</p>
</div>

	<span class="text-muted" v-if="this.messageButton() == 'Schedule'"><i class="far fa-calendar-alt"></i> Message will send on {{this.form.scheduled_at}} </span>
  </div>

  <div class="panel-bottom">
		<div class="panel-top_content float-left">
			<ScheduleMessages :slug='slug'></ScheduleMessages>
		</div>
      <div class="panel-top_content float-right">
				<a class="btn btn-link" @click="$modal.show('schedule-message')"><i class="far fa-calendar-alt"></i></a>
          <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
          <button class="btn panel-btn_save" type="submit">{{this.messageButton()}}</button>
      </div>
  </div>
</form>
        </div>
    </SubscriptionCheck>    
  </div>
    </modal>

        <!-- Schedule Modal-->
		<div>
		    <modal name="schedule-message" height="auto" :scrollable="true" width="45%"
	     class="model-desin"
	    :clickToClose=false >
	    <div class="edit-border-top p-3">
	    <div class="edit-border-bottom">
	        <div class="panel-top_content">
	            <span class="panel-heading">Schedule message</span>
	            <span class="panel-exit float-right" role="button" @click.prevent="modalFalse">x</span>
	        </div>
	    </div>
	        <div class="panel-form">
	<form class="">

	  <div class="panel-top_content">

			<span class="form-inline "><h6> Date: </h6>
				  <span> </span>	<datetime v-model="model.date" format="yyyy-MM-dd" ></datetime>
					 <span>: Message Schedule To </span>
				</span>

<span class="form-inline"> <h6> Time: </h6>
	  <datetime type="time" v-model="model.time" value-zone="local" zone="local"></datetime>
	</span>

	  </div>

	  <div class="panel-bottom">
	      <div class="panel-top_content float-right">
	          <button class="btn panel-btn_close" @click.prevent="modalFalse">Cancel</button>
						<button class="btn panel-btn_save" role="button" @click.prevent="scheduled()">Confirm</button>
	      </div>
	  </div>
	</form>
	        </div>
	  </div>
	    </modal>
		</div>
	</div>
</template>

<script>

	import ScheduleMessages from './Schedule.vue'
    import SubscriptionCheck from '../../SubscriptionChecker.vue';

export default {
	components: {ScheduleMessages,SubscriptionCheck},

  props:['slug','members'],
    data() {
      return {
        auth:this.$store.state.currentUser.user,
        newDate:moment().add(1, 'days').format("YYYY-MM-DD"),
        buttonMessage:'Send',
        form:{
		    date:'',
		    time:'',
            message:'',
            subject:'',
			mail:'',
			sms:'',
			users:[],
		    scheduled_at:'',
          },
		model:{
			date:'',
			time:'',
			},
        errors:{}
        };
    },
    methods: {
     sendMessage(){
      axios.post('/api/v1/projects/'+this.slug+'/message',{
        mail:this.form.mail,
		sms:this.form.sms,
        subject:this.form.subject,
        message:this.form.message,
		users:JSON.stringify(this.form.users),
		date:this.form.date,
		time:this.form.time
    }).then(response=>{
        this.$vToastify.success("Message Sent Successfully");
		this.modalClose();
    }).catch(error=>{
        this.errors=error.response.data.errors;
		this.$vToastify.warning("Failed To Send Message");
     });
  },

	scheduled(){
	 this.validateScheduled();

	 this.form.date = moment(this.model.date).format('YYYY-MM-DD'),
	 this.form.time = moment(this.model.time).format('HH:mm:ss'),
	 this.form.scheduled_at = this.scheduledTime();
     this.$modal.hide('schedule-message');
	},

	validateScheduled(){
      if (!this.model.date || !this.model.time) {
     return this.$vToastify.warning('Please select date and time');
     }

  if (this.model.date < this.newDate) {
    return this.$vToastify.warning('Date must be greater');
   }
 },

	scheduledTime(){
	 const date = this.$options.filters.date(this.model.date);
     const time = this.$options.filters.time(this.model.time);
       return `${date} at ${time}`;
	},

	messageButton(){
	 if(this.form.date && this.form.time){
		return "Schedule";
	}
		return "Send";
	},

  modalClose(){
   this.$modal.hide('project-message');
   this.errors='';
	 this.form={
		 date:'',
		 time:'',
		 message:'',
		 subject:'',
		 mail:'',
		 sms:'',
		 users:[],
		 scheduled_at:'',
	 };
 },
 modalFalse(){
	 this.$modal.hide('schedule-message');
	 this.form.date='';
   this.form.time='';
	 this.form.scheduled_at='';
 },

    }
}
</script>

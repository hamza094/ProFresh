<template>
	<div>
	    <modal name="schedule-message" height="auto" :scrollable="true" width="45%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3">
    <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="panel-heading">Send message to members</span>
            <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
        </div>
    </div>
        <div class="panel-form">
<form class="" @submit.prevent="projectMessage">
  <div class="panel-top_content">
    <div class="form-group">
        <label for="message" class="label-name">Subject:</label>
        <input type="text" id="subject" class="form-control" name="message" disabled>
    </div>
    <div class="form-group">
        <label for="subject" class="label-name">Message:</label>
        <textarea name="subject" class="form-control" rows="5"></textarea>
    </div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
			<label class="form-check-label" for="inlineCheckbox1">Send Message</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
			<label class="form-check-label" for="inlineCheckbox2">Send Sms</label>
		</div>
		<br><br>
		<label for="to" class="label-name">To: Select Project Member</label>
		<div class="check_members">
		<div class="form-check" v-for="user in  this.members">
	<input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
	<label class="form-check-label" for="defaultCheck1">
		{{user.name}} ({{user.email}})
	</label>
</div>
</div>
<br>

  </div>
  <div class="panel-bottom">
      <div class="panel-top_content float-right">
          <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
          <button class="btn panel-btn_save" type="submit">Send</button>
      </div>
  </div>
</form>
        </div>
  </div>
    </modal>


	</div>
</template>

<script>


export default {

	props:['slug','members'],

    data() {
        return {
          form:{
              /*email:this.project.email,
              message:'',
              subject:'',*/

          },
            //errors:{}
        };
    },
    methods: {

  projectMessage(){
    /*axios.post('/api/projects/'+this.project.id+'/mail',{
        email:this.form.email,
        subject:this.form.subject,
        message:this.form.message
    }).then(response=>{
        this.$vToastify.success("Mail Sent Successfully");
        this.form.subject="";
        this.form.message=""
        this.$modal.hide('project-message');
    }).catch(error=>{
         this.errors=error.response.data.errors
     });*/
  },

  modalClose(){
   this.$modal.hide('schedule-message');
   /*this.errors='';
   this.form.message='';
   this.form.subject='';*/
 },

    }
}
</script>

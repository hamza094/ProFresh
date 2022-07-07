<template>
	    <modal name="project-mail" height="100%" :scrollable="true" :shiftX="1" width="45%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3 animate__animated animate__slideInRight">
    <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="panel-heading">Send mail to project</span>
            <span class="panel-exit float-right" role="button" @click.prevent="mailClose">x</span>
        </div>
    </div>
        <div class="panel-form">
<form class="" @submit.prevent="projectMail">
  <div class="panel-top_content">
    <div class="form-group">
        <label for="to" class="label-name">To: Select Project Member</label>
        <select class="custom-select" id="to" name="email" v-model="form.email" required>
          <option v-for="user in  projectmembers"  v-bind:value="user.email">{{user.name}} ({{user.email}})</option>
        </select>

    </div>

    <div class="form-group">
        <label for="message" class="label-name">Subject:</label>
        <input type="text" id="subject" class="form-control" name="message" v-model="form.message">
    </div>
    <div class="form-group">
        <label for="subject" class="label-name">Message:</label>
        <textarea name="subject" class="form-control" rows="9" v-model="form.subject"></textarea>
    </div>
  </div>
  <div class="panel-bottom">
      <div class="panel-top_content float-right">
          <button class="btn panel-btn_close" @click.prevent="mailClose">Cancel</button>
          <button class="btn panel-btn_save" type="submit">Send</button>
      </div>
  </div>
</form>
        </div>
  </div>
    </modal>
</template>

<script>

export default {

  props:['project','members'],

    data() {
        return {
          form:{
              email:this.project.email,
              message:'',
              subject:'',

          },
          projectmembers:this.members,
            errors:{}
        };
    },
    methods: {

  projectMail(){
    axios.post('/api/projects/'+this.project.id+'/mail',{
        email:this.form.email,
        subject:this.form.subject,
        message:this.form.message
    }).then(response=>{
        this.$vToastify.success("Mail Sent Successfully");
        this.form.subject="";
        this.form.message=""
        this.$modal.hide('project-mail');
    }).catch(error=>{
         this.errors=error.response.data.errors
     });
  },

  mailClose(){
   this.$modal.hide('project-mail');
   this.errors='';
   this.form.message='';
   this.form.subject='';
 },

    }
}
</script>

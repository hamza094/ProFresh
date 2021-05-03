<template>
	 <div>
      <modal name="project-sms" height="100%" :scrollable="true" :shiftX="1" width="45%"
       class="model-desin"
      :clickToClose=false >
      <div class="edit-border-top p-3 animate__animated animate__slideInRight">
      <div class="edit-border-bottom">
          <div class="panel-top_content">
              <span class="panel-heading">Send sms to project</span>
              <span class="panel-exit float-right" role="button" @click.prevent="$modal.hide('project-sms')">x</span>
          </div>
      </div>
          <div class="panel-form">
  <form class="" @submit.prevent="projectSms">
    <div class="panel-top_content">
      <div class="form-group">
          <label for="mobile" class="label-name">Mobile Number:</label>
          <select class="custom-select" id="mobile" name="mobile" v-model="form.mobile" required>
            <option v-for="user in  projectmembers"  v-bind:value="user.mobile">
              <span v-if="user.mobile != null"> {{user.name}} ({{user.mobile}}) </span>
            </option>
          </select>
          <span class="text-danger font-italic" v-if="errors.mobile" v-text="errors.mobile[0]"></span>
          <span class="text-info font-italic">*Sms sent only on verified numbers due to trillo trial version sent mail to us to get verified number</span>
      </div>
      <div class="form-group">
          <label for="sms" class="label-name">Message:</label>
          <textarea name="sms" class="form-control" rows="5" v-model="form.sms"></textarea>
          <span class="text-danger font-italic" v-if="errors.sms" v-text="errors.sms[0]"></span>

      </div>
    </div>
    <div class="panel-bottom">
        <div class="panel-top_content float-right">
            <button class="btn panel-btn_close" @click.prevent="smsClose()">Cancel</button>
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
    props:['project','members'],
    data() {
        return {
          form:{
              mobile:this.project.mobile,
              sms:''

          },
          projectmembers:this.members,
            errors:{}
        };
    },

    methods: {
  smsClose(){
   this.$modal.hide('project-sms');
   this.errors='';
   this.form.sms='';
 },
 projectSms(){
   axios.post('/api/projects/'+this.project.id+'/sms',{
       mobile:this.form.mobile,
       sms:this.form.sms
   }).then(response=>{
       this.$vToastify.success("SMS Sent Successfully");
       this.form.sms="";
       this.$modal.hide('project-sms');
   }).catch(error=>{
        this.errors=error.response.data.errors
    });
 },

    }
}
</script>
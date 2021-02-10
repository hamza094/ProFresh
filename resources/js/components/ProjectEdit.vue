<template>

    <div class="float-right">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-project')">Edit Project</button>
    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content" v-if="authorize('projectOwner',project)" @click="forgetProject"><i class="far fa-trash-alt"></i> Forget</li>
    <li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-mail')"><i class="far fa-envelope"></i> Email</li>
    <li class="feature-dropdown_item-content" v-if="projectmembers != 0" @click="$modal.show('project-sms')"><i class="fas fa-mobile-alt"></i> Send SMS</li>
    <a v-bind:href="'/api/projects/' + this.project.id +'/export'"> <li class="feature-dropdown_item-content" @click="projectExport"><i class="fas fa-upload"></i>Export</li></a>
    <li class="feature-dropdown_item-content" @click="projectUnSubscribe" v-if="this.subscription"><i class="fas fa-inbox"></i> UnSubscribe</li>
    <li class="feature-dropdown_item-content" @click="projectSubscribe" v-else><i class="fas fa-inbox"></i> Subscribe</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Add to sequence</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Remove from sequence</li>
    <li class="feature-dropdown_item-content" v-if="authorize('projectOwner',project)" @click="deleteProject"><i class="far fa-trash-alt"></i> Delete</li>
  </ul>
</span>
    </span>

    <modal name="edit-project"
           height="auto" :scrollable="true" :shiftX="1" width="38%"
            class="model-desin"
           :clickToClose=false>
        <div class="edit-border-top p-3 animate__animated animate__slideInRight">
            <div class="edit-border-bottom">
                <div class="panel-top_content">
                    <span class="panel-heading">Edit Project {{project.name}}</span>
                    <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
                </div>
            </div>
            <div class="panel-form">
                    <form action="" @submit.prevent="updateProject">
                        <div class="panel-top_content">

                            <div class="form-group">
                                <label for="lastname" class="label-name">Name:</label>
                                <input type="text" id="lastname" class="form-control"  name="name" v-model="form.name">
                                <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="email" class="label-name">Email:</label>
                                <input type="text" id="email" class="form-control" name="email" v-model="form.email">
                                <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="company" class="label-name">Company:</label>
                                <input type="text" id="company" class="form-control" name="company" v-model="form.company">
                                <span class="text-danger font-italic" v-if="errors.company" v-text="errors.company[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="mobile" class="label-name">Mobile:</label>
                                <input type="text" id="mobile" class="form-control" name="mobile"  v-model="form.mobile">
                                <span class="text-danger font-italic" v-if="errors.mobile" v-text="errors.mobile[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="position" class="label-name">Position:</label>
                                <input type="text" id="position" class="form-control" name="position"  v-model="form.position">
                                <span class="text-danger font-italic" v-if="errors.position" v-text="errors.position[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="status" class="label-name">Zip Code:</label>
                                <input type="text" id="zipcode" class="form-control" name="zipcode"  v-model="form.zipcode">
                                <span class="text-danger font-italic" v-if="errors.zipcode" v-text="errors.zipcode[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="status" class="label-name">Address:</label>
                                <input type="text" id="address" class="form-control" name="address"  v-model="form.address">
                                <span class="text-danger font-italic" v-if="errors.address" v-text="errors.address[0]"></span>
                            </div>

                        </div>
                        <div class="panel-bottom">
                            <div class="panel-top_content float-right">
                                <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
                                <button class="btn panel-btn_save">Update</button>
                            </div>
                        </div>

                    </form>
                </div>
        </div>
    </modal>
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
            <button class="btn panel-btn_close" @click.prevent="mailClose()">Cancel</button>
            <button class="btn panel-btn_save" type="submit">Send</button>
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
export default {
    props:['project','subscribe','members'],
    data() {
        return {
          subscription:this.subscribe,
          form:{
              name:this.project.name,
              company:this.project.company,
              address:this.project.address,
              zipcode:this.project.zipcode,
              email:this.project.email,
              mobile:this.project.mobile,
              position:this.project.position,
              message:'',
              subject:'',
              mobile:this.project.mobile,
              sms:''

          },
          projectmembers:this.members,
           featurePop:false,
            errors:{}
        };
    },
    watch:{
        stagePop(featurePop){
            if(featurePop){
                document.addEventListener('click',this.zeroIfClickedOutside);
            }
        }
    },
    methods: {
        updateProject(){
           axios.patch('/api/projects/'+this.project.id,{
               name:this.form.name,
               company:this.form.company,
               address:this.form.address,
               zipcode:this.form.zipcode,
               email:this.form.email,
               mobile:this.form.mobile,
               position:this.form.position

           }).then(response=>{
               this.$vToastify.success("Project Updated Successfully");
               this.form="";
               location.reload();
           }).catch(error=>{
                console.log(error.response.data.errors);
            });
        },
        modalClose(){
            this.$modal.hide('edit-project');
            this.errors='';
        },
        zeroIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.featurePop=false;
                document.removeEventListener('click',this.zeroIfClickedOutside);
            }
        },
        forgetProject(){
          swal.fire({
         title: 'Are you sure?',
         text: "You can be able to revert this!",
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#3085d6',
         cancelButtonColor: '#d33',
         confirmButtonText: 'Yes, forget it!'
       }).then((result) => {
         if (result.value) {
         axios.delete('/api/projects/'+this.project.id).then(function(){
         swal.fire(
             'Success!',
             'Project has been forgetted.',
             'success'
           )
           setTimeout(()=>{
                window.location.href="/dashboard";
           },3000)
         }).catch(function(){
             swal.fire("Failed!","There was something wrong.","warning");
         });
     }
       })
     },
     deleteProject(){
       swal.fire({
      title: 'Are you sure?',
      text: "You can't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
      axios.get('/api/projects/'+this.project.id+'/delete').then(function(){
      swal.fire(
          'Success!',
          'Project has been deleted.',
          'success'
        )
        setTimeout(()=>{
             window.location.href="/dashboard";
        },3000)
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },
     deleteAvatar(){
       swal.fire({
      title: 'Are you sure?',
      text: "You action will delete avatar picture!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
      axios.patch('/api/projects/'+this.project.id+'/avatar-delete').then(function(){
        swal.fire(
            'Success!',
            'Project avatar has been deleted.',
            'success'
          )
        setTimeout(()=>{
             window.location.reload();
        },2000)
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },
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
   this.$modal.hide('project-sms');
   this.errors='';
   this.form.message='';
   this.form.subject='';
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
 projectExport(){
this.$vToastify.success("Data Export Successfully");
},
projectSubscribe(){
   axios.post('/api/projects/'+this.project.id+'/subscribe').
   then(response=>{
       this.subscription=true;
     this.$vToastify.success("Project Subscribed Successfully");
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},
projectUnSubscribe(){
axios.delete('/api/projects/'+this.project.id+'/unsubscribe').
then(response=>{
  this.subscription=false;
  this.$vToastify.info("Project UnSubscribed Successfully");
}).catch(error=>{
  console.log(error.response.data.errors);
});
}
    }
}
</script>

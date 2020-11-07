<template>

    <div class="float-right">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-lead')">Edit Lead</button>
    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content" @click="forgetLead"><i class="far fa-trash-alt"></i> Forget</li>
    <li class="feature-dropdown_item-content" @click="$modal.show('lead-mail')"><i class="far fa-envelope"></i> Email</li>
    <li class="feature-dropdown_item-content" @click="$modal.show('lead-sms')"><i class="fas fa-mobile-alt"></i> Send SMS</li>
    <a v-bind:href="'/api/leads/' + this.lead.id +'/export'"> <li class="feature-dropdown_item-content" @click="leadExport"><i class="fas fa-upload"></i>Export</li></a>
    <li v-if="lead.avatar_path!==null" class="feature-dropdown_item-content" @click="deleteAvatar"><i class="far fa-user-circle"></i> Remove display picture</li>
    <li class="feature-dropdown_item-content" @click="leadUnSubscribe" v-if="this.subscription"><i class="fas fa-inbox"></i> UnSubscribe</li>
    <li class="feature-dropdown_item-content" @click="leadSubscribe" v-else><i class="fas fa-inbox"></i> Subscribe</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Add to sequence</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Remove from sequence</li>
    <li class="feature-dropdown_item-content" @click="deleteLead"><i class="far fa-trash-alt"></i> Delete</li>
  </ul>
</span>
    </span>

    <modal name="edit-lead"
           height="auto" :scrollable="true" :shiftX="1" width="38%"
            class="model-desin"
           :clickToClose=false>
        <div class="edit-border-top p-3 animate__animated animate__slideInRight">
            <div class="edit-border-bottom">
                <div class="panel-top_content">
                    <span class="panel-heading">Edit Lead {{lead.name}}</span>
                    <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
                </div>
            </div>
            <div class="panel-form">
                    <form action="" @submit.prevent="updateLead">
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
                                <label for="owner" class="label-name">Sales owner:</label>
                                <input type="text" id="owner" class="form-control" name="owner"  v-model="form.owner">
                                <span class="text-danger font-italic" v-if="errors.owner" v-text="errors.owner[0]"></span>
                            </div>

                              <div class="form-group">
                                 <label for="status" class="label-name">Status: {{form.status}}</label>
                                <select class="custom-select" id="status" name="status" v-model="form.status">
                                  <option selected value="Subscribed">Subscribed</option>
                                  <option value="Unsubscribed">Unsubscribed</option>
                                  <option value="Not subscribed">Not subscribed</option>
                                  <option value="Reported as spam">Reported as spam</option>
                                  <option value="Bounced">Bounced</option>
                                <span class="text-danger font-italic" v-if="errors.status" v-text="errors.status[0]"></span>
                                </select>
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
    <modal name="lead-mail" height="100%" :scrollable="true" :shiftX="1" width="45%"
     class="model-desin"
    :clickToClose=false >
    <div class="edit-border-top p-3 animate__animated animate__slideInRight">
    <div class="edit-border-bottom">
        <div class="panel-top_content">
            <span class="panel-heading">Send mail to lead</span>
            <span class="panel-exit float-right" role="button" @click.prevent="mailClose">x</span>
        </div>
    </div>
        <div class="panel-form">
<form class="" @submit.prevent="leadSms">
  <div class="panel-top_content">
    <div class="form-group">
        <label for="to" class="label-name">To:</label>
        <input type="text" id="to" class="form-control"  name="to" v-model="form.email" Disabled>
    </div>

    <div class="form-group">
        <label for="message" class="label-name">Subject:</label>
        <input type="text" id="subject" class="form-control" name="message" v-model="form.message">
    </div>
    <div class="form-group">
        <label for="subject" class="label-name">Message:</label>
        <textarea name="subject" class="form-control" rows="12" v-model="form.subject"></textarea>
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
      <modal name="lead-sms" height="100%" :scrollable="true" :shiftX="1" width="45%"
       class="model-desin"
      :clickToClose=false >
      <div class="edit-border-top p-3 animate__animated animate__slideInRight">
      <div class="edit-border-bottom">
          <div class="panel-top_content">
              <span class="panel-heading">Send sms to lead</span>
              <span class="panel-exit float-right" role="button" @click.prevent="$modal.hide('lead-sms')">x</span>
          </div>
      </div>
          <div class="panel-form">
  <form class="" @submit.prevent="leadSms">
    <div class="panel-top_content">
      <div class="form-group">
          <label for="mobile" class="label-name">Mobile Number:</label>
          <input type="text" id="to" class="form-control"  name="mobile" v-model="form.mobile" Disabled>
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
    props:['lead','subscribe'],
    data() {
        return {
          subscription:this.subscribe,
          form:{
              name:this.lead.name,
              company:this.lead.company,
              address:this.lead.address,
              zipcode:this.lead.zipcode,
              email:this.lead.email,
              mobile:this.lead.mobile,
              status:this.lead.status,
              owner:this.lead.owner,
              position:this.lead.position,
              message:'',
              subject:'',
              mobile:this.lead.mobile,
              sms:''

          },
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
        updateLead(){
           axios.patch('/api/leads/'+this.lead.id,{
               name:this.form.name,
               company:this.form.company,
               address:this.form.address,
               zipcode:this.form.zipcode,
               email:this.form.email,
               mobile:this.form.mobile,
               status:this.form.status,
               owner:this.form.owner,
               position:this.form.position

           }).then(response=>{
               this.$vToastify.success("Lead Updated Successfully");
               this.form="";
               location.reload();
           }).catch(error=>{
                console.log(error.response.data.errors);
            });
        },
        modalClose(){
            this.$modal.hide('edit-lead');
            this.errors='';
        },
        zeroIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.featurePop=false;
                document.removeEventListener('click',this.zeroIfClickedOutside);
            }
        },
        forgetLead(){
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
         axios.delete('/api/leads/'+this.lead.id).then(function(){
         swal.fire(
             'Success!',
             'Lead has been forgetted.',
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
     deleteLead(){
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
      axios.get('/api/leads/'+this.lead.id+'/delete').then(function(){
      swal.fire(
          'Success!',
          'Lead has been deleted.',
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
      axios.patch('/api/leads/'+this.lead.id+'/avatar-delete').then(function(){
        swal.fire(
            'Success!',
            'Lead avatar has been deleted.',
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
  leadMail(){
    axios.post('/email/api/leads/'+this.lead.id+'/mail',{
        email:this.form.email,
        subject:this.form.subject,
        message:this.form.message
    }).then(response=>{
        this.$vToastify.success("Mail Sent Successfully");
        this.form.subject="";
        this.form.message=""
        this.$modal.hide('lead-mail');
    }).catch(error=>{
         this.errors=error.response.data.errors
     });
  },

  mailClose(){
   this.$modal.hide('lead-mail');
   this.$modal.hide('lead-sms');
   this.errors='';
   this.form.message='';
   this.form.subject='';
   this.form.sms='';
 },
 leadSms(){
   axios.post('/api/leads/'+this.lead.id+'/sms',{
       mobile:this.form.mobile,
       sms:this.form.sms
   }).then(response=>{
       this.$vToastify.success("SMS Sent Successfully");
       this.form.sms="";
       this.$modal.hide('lead-sms');
   }).catch(error=>{
        this.errors=error.response.data.errors
    });
 },
 leadExport(){
this.$vToastify.success("Data Export Successfully");
},
leadSubscribe(){
   axios.post('/api/leads/'+this.lead.id+'/subscribe').
   then(response=>{
       this.subscription=true;
     this.$vToastify.success("Lead Subscribed Successfully");
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
},
leadUnSubscribe(){
axios.delete('/api/leads/'+this.lead.id+'/unsubscribe').
then(response=>{
  this.subscription=false;
  this.$vToastify.info("Lead UnSubscribed Successfully");
}).catch(error=>{
  console.log(error.response.data.errors);
});
}
    }
}
</script>

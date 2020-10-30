<template>

    <div class="float-right">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-lead')">Edit Lead</button>
    <span class="feature-dropdown" @click="featurePop = !featurePop">
<span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
<span class="feature-dropdown_item" v-show=featurePop>
  <ul>
    <li class="feature-dropdown_item-content"><i class="far fa-trash-alt"></i> Trash</li>
    <li class="feature-dropdown_item-content"><i class="far fa-envelope"></i> Email</li>
    <li class="feature-dropdown_item-content"><i class="fas fa-mobile-alt"></i> Send SMS</li>
    <li class="feature-dropdown_item-content"><i class="fas fa-upload"></i> Export</li>
    <li class="feature-dropdown_item-content"><i class="far fa-user-circle"></i> Remove display picture</li>
    <li class="feature-dropdown_item-content"><i class="fas fa-inbox"></i> Unsubscribe</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Add to sequence</li>
    <li class="feature-dropdown_item-content"><i class="fab fa-500px"></i> Remove from sequence</li>
    <li class="feature-dropdown_item-content"><i class="far fa-trash-alt"></i> Delete</li>
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
                                <button class="btn panel-btn_save" >Update</button>
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
    props:['lead'],
    data() {
        return {
          form:{
              name:this.lead.name,
              company:this.lead.company,
              address:this.lead.address,
              zipcode:this.lead.zipcode,
              email:this.lead.email,
              mobile:this.lead.mobile,
              status:this.lead.status,
              owner:this.lead.owner,
              position:this.lead.position
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
                this.errors=error.response.data.errors
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

    }
}
</script>

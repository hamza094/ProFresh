<template>

    <div class="float-right">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-lead')">Edit Lead</button>

    <modal name="edit-lead"
           height="auto" :scrollable="true" :shiftX="1" width="38%"
            class="model-desin"
           :clickToClose=false>
        <div class="edit-border-top p-3 animate__animated animate__slideInRight">
            <div class="edit-border-bottom">
                <div class="panel-top_content">
                    <span class="panel-heading">Edit Lead {{lead.name}}</span>
                    <span class="panel-exit float-right" role="button" @click.prevent="$modal.hide('edit-lead')">x</span>
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
                                <label for="company" class="label-name">Company:</label>
                                <input type="text" id="company" class="form-control" name="company" v-model="form.company">
                                <span class="text-danger font-italic" v-if="errors.company" v-text="errors.company[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="email" class="label-name">Email:</label>
                                <input type="text" id="email" class="form-control" name="email" v-model="form.email">
                                <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="mobile" class="label-name">Mobile:</label>
                                <input type="text" id="mobile" class="form-control" name="mobile"  v-model="form.mobile">
                                <span class="text-danger font-italic" v-if="errors.mobile" v-text="errors.mobile[0]"></span>


                            </div>
                            <div class="form-group">
                                <label for="work" class="label-name">Work:</label>
                                <input type="text" id="work" class="form-control" name="work"  v-model="form.work">
                                <span class="text-danger font-italic" v-if="errors.work" v-text="errors.work[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="owner" class="label-name">Sales owner:</label>
                                <input type="text" id="owner" class="form-control" name="owner"  v-model="form.owner">
                                <span class="text-danger font-italic" v-if="errors.owner" v-text="errors.owner[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="stage" class="label-name">Lead Stage:</label>
                                <input type="text" id="stage" class="form-control" name="stage"  v-model="form.stage"v>
                                <span class="text-danger font-italic" v-if="errors.stage" v-text="errors.stage[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="status" class="label-name">Subscription status:</label>
                                <input type="text" id="status" class="form-control" name="status"  v-model="form.status">
                                <span class="text-danger font-italic" v-if="errors.status" v-text="errors.status[0]"></span>

                            </div>
                            <div class="form-group">
                                <label for="status" class="label-name">Zip Code:</label>
                                <input type="text" id="zip" class="form-control" name="zip"  v-model="form.zip">
                                <span class="text-danger font-italic" v-if="errors.zip" v-text="errors.zip[0]"></span>

                            </div>
                        </div>
                        <div class="panel-bottom">
                            <div class="panel-top_content float-right">
                                <button class="btn panel-btn_close" @click.prevent="$modal.hide('edit-lead')">Cancel</button>
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
              zip:this.lead.zip,
              email:this.lead.email,
              mobile:this.lead.mobile,
              status:this.lead.status,
              stage:this.lead.stage,
              owner:this.lead.owner,
          },
            errors:{}
        };
    },
    methods: {
        updateLead(){
           axios.patch('/api/leads/'+this.lead.id,{
               name:this.form.name,
               company:this.form.company,
               address:this.form.address,
               zip:this.form.zip,
               email:this.form.email,
               mobile:this.form.mobile,
               status:this.form.status,
               owner:this.form.owner,

           }).then(response=>{
               this.$vToastify.success("Lead Updated Successfully");
               this.form="";
               location.reload();
           }).catch(error=>{
                this.errors=error.response.data.errors
            });
        }
    }
}
</script>

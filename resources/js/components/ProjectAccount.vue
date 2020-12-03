<template>
  <div class="project-account">
    <div class="project-empty">
      <h4>No Account Associated to this project</h4>
      <p class="btn panel-btn_save" @click.prevent="$modal.show('project-account')">Add Account</p>
    </div>
    <div>
      <modal name="project-account"
             height="auto" :scrollable="true" :shiftX="1" width="38%"
              class="model-desin"
             :clickToClose=false>
          <div class="edit-border-top p-3 animate__animated animate__slideInRight">
              <div class="edit-border-bottom">
                  <div class="panel-top_content">
                      <span class="panel-heading">Add Project Account</span>
                      <span class="panel-exit float-right" role="button" @click.prevent="modalClose()">x</span>
                  </div>
              </div>
              <div class="panel-form">
                      <form action="" @submit.prevent="ProjectAccount">
                          <div class="panel-top_content">
                              <div class="form-group">
                                  <label for="title" class="label-name">Title:</label>
                                  <input type="text" id="title" class="form-control" name="title" v-model="form.title">
                                  <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="country" class="label-name">Country:</label>
                                  <input type="text" id="country" class="form-control" name="country" v-model="form.country">
                                  <span class="text-danger font-italic" v-if="errors.country" v-text="errors.country[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="address" class="label-name">Address:</label>
                                  <input type="text" id="address" class="form-control" name="address" v-model="form.address">
                                  <span class="text-danger font-italic" v-if="errors.address" v-text="errors.address[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="zipcode" class="label-name">Zip Code:</label>
                                  <input type="text" id="zipcode" class="form-control" name="zipcode" v-model="form.zipcode">
                                  <span class="text-danger font-italic" v-if="errors.zipcode" v-text="errors.zipcode[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="website" class="label-name">Web Address:</label>
                                  <input type="text" id="web" class="form-control" name="website" v-model="form.website">
                                  <span class="text-danger font-italic" v-if="errors.website" v-text="errors.website[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="number" class="label-name">Number:</label>
                                  <input type="text" id="number" class="form-control" name="number" v-model="form.number">
                                  <span class="text-danger font-italic" v-if="errors.number" v-text="errors.number[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="industry" class="label-name">Industry Type:</label>
                                  <input type="text" id="industry" class="form-control" name="industry" v-model="form.industry">
                                  <span class="text-danger font-italic" v-if="errors.industry" v-text="errors.industry[0]"></span>
                              </div>

                              <div class="form-group">
                                  <label for="business" class="label-name">Business:</label>
                                  <input type="text" id="business" class="form-control" name="business" v-model="form.business">
                                  <span class="text-danger font-italic" v-if="errors.business" v-text="errors.business[0]"></span>
                               </div>

                               <div class="form-group">
                                   <label for="employee" class="label-name">Employee Number:</label>
                                   <input type="text" id="employee" class="form-control" name="employee" v-model="form.employee">
                                   <span class="text-danger font-italic" v-if="errors.employee" v-text="errors.employee[0]"></span>

                               </div>
                              <div class="form-group">
                                  <label for="revenue" class="label-name">Revenue:</label>
                                  <input type="text" id="revenue" class="form-control" name="revenue" v-model="form.revenue">
                                  <span class="text-danger font-italic" v-if="errors.revenue" v-text="errors.revenue[0]"></span>
                              </div>

                          </div>
                          <div class="panel-bottom">
                              <div class="panel-top_content float-right">
                                  <button class="btn panel-btn_close" @click.prevent="modalClose()">Cancel</button>
                                  <button class="btn panel-btn_save" type="submit">Add Acount</button>
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
export default{
  props:['project'],
  data(){
    return{
     form:{},
     errors:{},
   };

  },
  methods:{
ProjectAccount(){
  axios.post('/api/project/'+this.project.id+'/account',this.form)
     .then(response=>{
         this.$vToastify.success("Project account added");
         this.form="";
         this.modalClose();
         setTimeout(()=>{
             location=response.data.message;
         },3000)

     }).catch(error=>{
      this.errors=error.response.data.errors;
  });
},
modalClose(){
  this.$modal.hide('project-account');
  this.form="";
  this.errors="";
}
  }
}
</script>

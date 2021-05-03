<template>
    <modal name="edit-project"
           height="auto" :scrollable="true" :shiftX="1" width="38%"
            class="model-desin"
           :clickToClose=false>
        <div class="edit-border-top p-3 animate__animated animate__slideInRight">
            <div class="edit-border-bottom">
                <div class="panel-top_content">
                    <span class="panel-heading">Update Project {{project.name}}</span>
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
</template>


<script>
export default {
    props:['project'],
    data() {
        return {
          form:{
              name:this.project.name,
              company:this.project.company,
              address:this.project.address,
              zipcode:this.project.zipcode,
              email:this.project.email,
              mobile:this.project.mobile,
              position:this.project.position,
          },
            errors:{}
        };
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
    }
}
</script>	
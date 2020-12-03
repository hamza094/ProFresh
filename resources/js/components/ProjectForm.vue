<template>
    <div class="panel">
       <div class="panel-top">
          <div class="panel-top_content">
            <span class="panel-heading">Add Project</span>
           <span class="panel-exit float-right" role="button" @click.prevent="closePanel">x</span>
          </div>
       </div>
        <div class="panel-form">
                <form action="">
                    <div class="panel-top_content">
                        <div class="form-group">
                        <label for="name" class="label-name">Name:</label>
                        <input type="text" id="lastname" class="form-control" v-model="form.name" name="name" placeholder="Enter value">
                            <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                        </div>

                        <div class="form-group">
                            <label for="email" class="label-name">Email:</label>
                            <input type="text" id="email" class="form-control" name="email" v-model="form.email" placeholder="Enter value" >
                            <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="label-name">Mobile:</label>
                            <input type="text" id="mobile" class="form-control" name="mobile" v-model="form.mobile" placeholder="Enter value">
                            <span class="text-danger font-italic" v-if="errors.mobile" v-text="errors.mobile[0]"></span>
                        </div>

                    <div class="form-group">
                        <label for="company" class="label-name">Company:</label>
                        <input type="text" id="company" class="form-control" name="company" v-model="form.company" placeholder="Enter value">
                        <span class="text-danger font-italic" v-if="errors.company" v-text="errors.company[0]"></span>
                    </div>
                    <div class="form-group">
                        <label for="position" class="label-name">Position:</label>
                        <input type="text" id="position" class="form-control" name="position" v-model="form.position" placeholder="Enter value">
                        <span class="text-danger font-italic" v-if="errors.position" v-text="errors.position[0]"></span>

                    </div>
                    <div class="form-group">
                        <label for="owner" class="label-name">Sales owner:</label>
                        <input type="text" id="owner" class="form-control" name="owner" v-model="form.owner" placeholder="Enter value" >
                        <span class="text-danger font-italic" v-if="errors.owner" v-text="errors.owner[0]"></span>
                    </div>
                        <div class="form-group">
                            <label for="owner" class="label-name">Zipcode:</label>
                            <input type="text" id="zipcode" class="form-control" name="zipcode" v-model="form.zipcode" placeholder="Enter value" >
                            <span class="text-danger font-italic" v-if="errors.zipcode" v-text="errors.zipcode[0]"></span>
                        </div>
                        <div class="form-group">
                            <label for="owner" class="label-name">Address:</label>
                            <input type="text" id="address" class="form-control" name="address" v-model="form.address" placeholder="Enter value">
                            <span class="text-danger font-italic" v-if="errors.address" v-text="errors.address[0]"></span>
                        </div>
                    </div>
                    <div class="panel-bottom">
                        <div class="panel-top_content float-right">
                        <button class="btn panel-btn_close" @click.prevent="closePanel">Cancel</button>
                            <button class="btn panel-btn_save" @click.prevent="projectSubmit">Save</button>
                        </div>
                    </div>

                </form>
        </div>
    </div>



</template>


<script>
export default{
    data(){
        return{
           form:{},
            errors:{},
        };
    },
    methods:{
        closePanel() {
            this.$emit("closePanel", {});
            this.errors={};
            this.form={};
        },
        projectSubmit(){
         axios.post('/api/projects',this.form)
            .then(response=>{
                this.$vToastify.success("Project added");
                this.form="";
                this.closePanel();
                setTimeout(()=>{
                    location=response.data.message;
                },3000)

            }).catch(error=>{
             this.errors=error.response.data.errors;
         });
        }

    },
}
</script>

<template>
    <div class="panel">
       <div class="panel-top">
          <div class="panel-top_content">
            <span class="panel-heading">Add Lead</span>
           <span class="panel-exit float-right" role="button" @click.prevent="closePanel">x</span>
          </div>
       </div>
        <div class="panel-form">
                <form action="">
                    <div class="panel-top_content">
                        <div class="form-group">
                        <label for="lastname" class="label-name">Name:</label>
                        <input type="text" id="lastname" class="form-control" v-model="form.name" name="lastname" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="company" class="label-name">Company:</label>
                        <input type="text" id="company" class="form-control" name="company" v-model="form.company" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-name">Email:</label>
                        <input type="text" id="email" class="form-control" name="email" v-model="form.email" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="label-name">Mobile:</label>
                        <input type="text" id="mobile" class="form-control" name="mobile" v-model="form.mobile" placeholder="Enter value">
                    </div>
                    <div class="form-group">
                        <label for="work" class="label-name">Work:</label>
                        <input type="text" id="work" class="form-control" name="work" v-model="form.work" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="owner" class="label-name">Sales owner:</label>
                        <input type="text" id="owner" class="form-control" name="owner" v-model="form.owner" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="stage" class="label-name">Lead Stage:</label>
                        <input type="text" id="stage" class="form-control" name="stage" v-model="form.stage" placeholder="Enter value">
                    </div>
                    <div class="form-group">
                        <label for="status" class="label-name">Subscription status:</label>
                        <input type="text" id="status" class="form-control" name="status" v-model="form.status" placeholder="Enter value">
                    </div>
                    </div>
                    <div class="panel-bottom">
                        <div class="panel-top_content float-right">
                        <button class="btn panel-btn_close" @click.prevent="closePanel">Cancel</button>
                            <button class="btn panel-btn_save" @click.prevent="leadSubmit">Save</button>
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
            errors:{}
        };
    },
    methods:{
        closePanel() {
            this.$emit("closePanel", {});
            this.errors={};
            this.form={};
        },
        leadSubmit(){
         axios.post('/api/leads',this.form)
            .then(response=>{
                this.$vToastify.success("Lead added");
                this.form="";
                this.closePanel();
         }).catch(errors=>{
             console.log('error');
         });
        }

    }
}
</script>

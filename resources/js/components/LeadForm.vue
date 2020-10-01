<template>
    <div class="panel">
       <div class="panel-top">
          <div class="panel-top_content">
            <span class="panel-heading">Add Lead</span>
           <sapn class="panel-exit float-right" role="button" v-on:click.prevent="closePanel">x</sapn>
          </div>
       </div>
        <div class="panel-form">
                <form action="">
                    <div class="panel-top_content">
                    <div class="form-group">
                        <label for="firstname" class="label-name">First Name:</label>
                        <input type="text" id="firstname" class="form-control" name="firstname" placeholder="Enter value" required>
                    </div>
                        <div class="form-group">
                        <label for="lastname" class="label-name">Last Name:</label>
                        <input type="text" id="lastname" class="form-control" name="lastname" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="company" class="label-name">Company:</label>
                        <input type="text" id="company" class="form-control" name="company" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="label-name">Email:</label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="label-name">Mobile:</label>
                        <input type="text" id="mobile" class="form-control" name="mobile" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="work" class="label-name">Work:</label>
                        <input type="text" id="work" class="form-control" name="work" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="salesowner" class="label-name">Sales owner:</label>
                        <input type="text" id="salesowner" class="form-control" name="mobile" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="stage" class="label-name">Lead Stage:</label>
                        <input type="text" id="stage" class="form-control" name="stage" placeholder="Enter value" required>
                    </div>
                    <div class="form-group">
                        <label for="status" class="label-name">Subscription status:</label>
                        <input type="text" id="status" class="form-control" name="status" placeholder="Enter value" required>
                    </div>
                    </div>
                    <div class="panel-bottom">
                        <div class="panel-top_content float-right">
                        <button class="btn panel-btn_close" v-on:click.prevent="closePanel">Cancel</button>
                            <button class="btn panel-btn_save">Save</button>
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
            closePanel() {
      this.$emit("closePanel", {});
    }
        };
    },
    methods:{

    }
}
</script>

<template>
	<div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form">
                <div class="form-header">Reset Password</div>
                <h5>Enter your new password</h5>
                <div class="form-body">
                    <form method="POST" @submit.prevent="resetPassword">
                        <div class="form-group">
                            <label for="email" class="form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" v-model="form.email" value="" required autocomplete="email">
                                 <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" v-model="form.password" required autocomplete="new-password">
                                 <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="form-label">Confirm Password</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation" required autocomplete="new-password">
                                 <span class="text-danger font-italic" v-if="errors.password_confirmation" v-text="errors.password_confirmation[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <button type="submit" class="form-btn">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
</template>

<script>

export default{
	data(){
		return{
      errors:{},
			form:{
              email:'',
              password:'',
              password_confirmation:''
            }
		};
	},
	methods:{
      resetPassword(){
        axios.post('/api/v1/reset-password',this.form,{
               token: this.$route.params.token
      }).then(response=>{
        swal.fire("Password Changed","Please Login to continue","success");
          this.$router.push('/login');
         }).catch(error=>{
           this.errors=error.response.data.errors;
      });
      }
    }
}

</script>

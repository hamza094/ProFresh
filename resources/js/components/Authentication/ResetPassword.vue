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
                                <input
id="email" type="email" class="form-control" name="email" v-model="form.email" required autocomplete="email"
                                readonly >
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
    mounted() {
    // Get the email from the query parameters and set it in the form
    const emailFromQuery = this.$route.query.email;
    if (emailFromQuery) {
      this.form.email = decodeURIComponent(emailFromQuery);
    }
  },
	methods:{
      resetPassword(){
        this.$Progress.start();
        axios.post('/api/v1/reset-password',{
					email: this.form.email,
					password: this.form.password,
					password_confirmation: this.form.password_confirmation,
          token: this.$route.params.token
            }).then(()=>{
        this.$Progress.finish();
        swal.fire("Password Changed","Please Login to continue","success");
          this.$router.push('/login');
         }).catch(error=>{
            this.$Progress.fail();
           this.errors=error.response.data.errors;
      });
      }
    }
}

</script>

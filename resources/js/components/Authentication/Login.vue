<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form">
                <div class="form-header">Sign In</div>

                <div class="form-body">
                    <form method="POST" @submit.prevent="userLogin">
                        <div class="form-group">
                            <label for="email" class="form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" v-model="form.email" required autocomplete="email" autofocus>
                                 <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" v-model="form.password" required autocomplete="current-password">
                                <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" v-model="form.remember" id="remember">

                                    <label class="form-check-label form-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <button type="submit" class="form-btn mb-3">
                                    Sign In
                                </button>
                            </div>
                        </div>
                    </form>
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
                remember:''
            }
		};
	},

	methods:{
		userLogin(){
        axios.post('/api/v1/login',this.form,{
      }).then(response=>{

        let accessToken= JSON.stringify('Bearer ' + response.data.access_token);

        let bearerToken= accessToken.replace(/\\n/g, '');

        localStorage.setItem('token',bearerToken);

        this.$bus.$emit('logged', 'User logged');

        this.$vToastify.success("You are login successfully");

        this.$router.push('/home');
         }).catch(error=>{
           this.errors=error.response.data.errors;
      });
		},
    }
}

</script>

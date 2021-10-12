<template>
	<div>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form">
                <div class="form-header">Sign Up</div>
                <div class="form-body">
                    <form method="POST" @submit.prevent="RegisterUser">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" v-model="form.name" required autocomplete="name" autofocus>
                                 <span class="text-danger font-italic" v-if="errors.password" v-text="errors.name[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" v-model="form.email" value="" required autocomplete="email">
                                 <span class="text-danger font-italic" v-if="errors.password" v-text="errors.email[0]"></span>
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
                                 <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password_confirmation[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <button type="submit" class="form-btn">
                                    Sign Up
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
	props:[],

		

	data(){
		return{
             errors:{},
			form:{
                name:'',
                email:'',
                password:'',
                password_confirmation:''

            }
		};
	},
	methods:{
      RegisterUser(){
        axios.post('/api/register',{
        name:this.form.name,
        email:this.form.email,
        password:this.form.password,
        password_confirmation:this.form.password_confirmation,
      }).then(response=>{
          window.location.href='/login';
         }).catch(error=>{
           this.errors=error.response.data.errors;
      });
      }
    }
}	

</script>
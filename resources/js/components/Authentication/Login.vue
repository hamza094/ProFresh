<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form">
                <div class="form-header">Sign In</div>

                <div class="form-body">
                    <form method="POST" @submit.prevent="login()">
                        <div class="form-group">
                            <label for="email" class="form-label">E-Mail Address</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" v-model="user.email" required autocomplete="email" autofocus>
                                 <span class="text-danger font-italic" v-if="this.errors.email" v-text="this.errors.email[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" v-model="user.password" required autocomplete="current-password">
                                <span class="text-danger font-italic" v-if="this.errors.password" v-text="this.errors.password[0]"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" v-model="user.remember" id="remember">

                                    <label class="form-check-label form-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <router-link to="/forgot-password">
                            <span>Forget Password?</span>
                        </router-link>

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

export default {
	data(){
		return{
			 user:{
              email:'',
              password:'',
              remember:''
            }
		};
	},
  computed:{
    errors:{
      get(){
        return this.$store.state.currentUser.errors
      }
    }
  },

	methods:{
    login(){
      this.$store.dispatch('currentUser/loginUser',this.user);
    }
    }
}

</script>

<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Profresh Managment Area</div>

                <div class="alert alert-success" role="alert" v-if="!user.verified">
                  To access all features, please verify your account.
                  <span class="btn btn-sm btn-primary" @click="resendMail()">Resend verification mail</span>
                  </div>
                 <p class="mt-3"><b>Welcome To ProFresh Project Managment App</b></p>
                 
                </div>
                <div class="card-body">
                
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  import { mapState, mapActions } from 'vuex';
export default{
    computed:{   
        ...mapState('subscribeUser',['subscription']),
      user:{
        get(){
          return this.$store.state.currentUser.user
        }
      }
  },
    methods:{
        ...mapActions('subscribeUser',['userSubscription']),
       resendMail(){
           axios.post('/api/v1/email/resend/'+this.user.uuid,{})
           .then(() => {
               this.$vToastify.success("Verification link sent successfully");
           }).catch(error => {
             const msg = error?.response?.data?.message || error?.message || 'Error! Please try again';
             this.$vToastify.warning(msg);
           });
         }
    },
}
</script>

<template>
  <div class="container">
  <div class="text-center mt-5">
    <h3>Please wait while we sign you into ProFresh</h3>
    <div class="d-flex mt-3 justify-content-center align-items-center">
      <ring-loader :color=this.color :size="100" />
    </div>
  </div>
</div>
</template>

<script>
    import { mapState, mapMutations, mapActions } from 'vuex';
export default {
  name: 'MyComponent',
  data() {
    return {
     color:'#301934' 
    }
  },
  props: {
    
  },
  methods: {
    ...mapActions('currentUser',['createUserToken']),
    ...mapMutations('currentUser',['setUser','loggedIn']),

    socialLogin(){
      if (window.location.pathname.includes('/auth/callback/')) {
      const provider = window.location.pathname.split('/').pop();
      const code = this.$route.query.code;
   // extract provider from URL
  axios.get(`/api/v1/auth/callback/${provider}?code=${code}`)
    .then(response => {
      this.$store.commit('currentUser/setUser', response.data.user);
      this.$store.commit('currentUser/loggedIn', true);
      this.$store.dispatch('currentUser/createUserToken',response);
      this.$router.push('/home');
      this.$vToastify.success('You have successfully logged in to the site');    
    })
    .catch(error => {
        this.$vToastify.warning(error.response.data.error);    
    });
   }
    },
  },
  mounted() {
      this.socialLogin();
  }
}
</script>

<style scoped>
</style>

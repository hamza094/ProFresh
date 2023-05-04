<template>
  <div>
    <h1>Logging you into ProFresh</h1>
  </div>
</template>

<script>
    import { mapState, mapMutations, mapActions } from 'vuex';
export default {
  name: 'MyComponent',
  data() {
    return {
      
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
    })
    .catch(error => {
      console.error(error);
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

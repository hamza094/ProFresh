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
import { mapActions } from 'vuex';
import router from '../../router';
export default {
  name: 'MyComponent',
  data() {
    return {
     color:'#301934' 
    }
  },
  methods: {
    ...mapActions('currentUser', ['handleLoginResponse']),
    socialLogin(){
      if (window.location.pathname.includes('/auth/callback/')) {
        const provider = window.location.pathname.split('/').pop();
        const code = this.$route.query.code;
        axios.get(`/api/v1/auth/callback/${provider}?code=${code}`)
          .then(response => {
            this.handleLoginResponse(response);
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

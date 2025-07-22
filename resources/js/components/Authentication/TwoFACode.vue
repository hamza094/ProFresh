<template>
  <div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
      <h5 class="mb-3 text-center">Enter Two-Factor Authentication Code</h5>
      <form @submit.prevent="submitCode">
        <div class="form-group mb-3">
          <input
            type="text"
            v-model="code"
            class="form-control text-center"
            maxlength="6"
            placeholder="6-digit code"
            autocomplete="one-time-code"
            required
            autofocus
          />
        </div>
        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
          <span v-if="loading" class="spinner-border spinner-border-sm mr-1" role="status"></span>
          Verify
        </button>
        <div v-if="error" class="text-danger mt-3 text-center small">{{ error }}</div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      code: '',
      loading: false,
      error: '',
      user:{
              email:'',
              password:'',
              remember:''
            }
    };
  },
  methods: {
    async submitCode() {
      this.loading = true;
      this.error = '';
      try {
        const res = await axios.post("/api/v1/twofactor/login-confirm", {
          code: this.code
        });
        this.$vToastify.success("2FA successfully verified.");
        // Clear 2FA pending flag
        localStorage.removeItem('twofa_pending');
        localStorage.removeItem('twofa_timestamp');
        // Store token and user info
        this.$store.dispatch('currentUser/createUserToken', res);
        this.$store.commit('currentUser/setUser', res.data.user);
        this.$store.commit('currentUser/loggedIn', true);
        this.$store.commit('currentUser/setToken', res.data.access_token);
        this.$router.push('/home');
      } catch (e) {
         if (e.response?.status === 422) {
        this.error = e.response?.data?.errors?.code?.[0] || 'Invalid code format';
    } else if (e.response?.status === 401) {
        this.error = 'Session expired. Please login again.';
    } else {
        this.error = 'Network error. Please try again.';
    }
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>
.card {
  border-radius: 8px;
}
input.form-control {
  font-size: 1.2rem;
  letter-spacing: 0.2em;
}
</style>

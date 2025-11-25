<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="card">
          <div class="form">
            <div class="card-title">Account Verification</div>
            <div class="card-body" v-if="success">
              <span class="badge badge-success"
                ><h5>Your Account has been verified Successfully. Please log in to continue</h5></span
              >
            </div>
            <div class="card-body" v-if="error === 'verification.already_verified'">
              <span class="badge badge-info"><h5>Account already verified. Please log in to continue</h5></span>
            </div>
            <div class="card-body" v-if="error === 'verification.invalid'">
              <span class="badge badge-danger"
                ><h5>Verification Error. Please log in to get the verified link again</h5></span
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Use axios `params` for query encoding instead of manual builder
export default {
  async beforeRouteEnter(to, from, next) {
    try {
      const { data } = await axios.post(
        `/email/verify/${encodeURIComponent(to.params.user)}`,
        null,
        { params: to.query },
      );
      next((vm) => {
        vm.success = data.status;
        vm.$store.dispatch('currentUser/updateVerifiedStatus', true);
      });
    } catch (e) {
      next((vm) => {
        vm.error = e.response?.data?.status || 'verification.invalid';
      });
    }
  },
  data: () => ({
    error: '',
    success: '',
  }),
};
</script>

<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="form">
          <div class="form-header">Forgot Password</div>
          <h5>Enter Email address to get password reset link</h5>
          <div class="form-body">
            <form method="POST" @submit.prevent="resetLink">
              <div class="form-group">
                <label for="email" class="form-label">E-Mail Address</label>

                <div class="col-md-8">
                  <input
                    id="email"
                    type="email"
                    class="form-control"
                    name="email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                    autofocus />
                  <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-8">
                  <button type="submit" class="form-btn mb-3">Send Reset Link</button>
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
  data() {
    return {
      errors: {},
      form: {
        email: '',
      },
    };
  },

  methods: {
    resetLink() {
      axios
        .post('/forgot-password', this.form, {})
        .then(() => {
          this.$vToastify.success('Reset Email sent successfully check your inbox');
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>

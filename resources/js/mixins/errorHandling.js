export default {
  methods: {
    handleErrorResponse(error) {
      this.errors = error.response?.data?.errors || {};
      const errorMessage = error.response?.data?.error || 'An unexpected error occurred.';
      this.$vToastify.error(errorMessage);
    }
  },

}
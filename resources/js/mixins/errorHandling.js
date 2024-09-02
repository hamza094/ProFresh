export default {
  methods: {
    handleErrorResponse(error) {
      if (error.response && error.response.data && error.response.data.errors) {
        this.errors = error.response.data.errors;
      } else if (error.response && error.response.data && error.response.data.error) {
        this.$vToastify.error(error.response.data.error);
      } else {
        this.$vToastify.error('An unexpected error occurred.');
      }
    },
  },
};
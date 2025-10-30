export default {
  methods: {
    getProjectSlug() {
      let name = window.location.pathname;
      let path = name.substring(name.indexOf('/') + 10);
      return path;
    },
  },
};

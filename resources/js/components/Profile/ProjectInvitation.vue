<template>
  <div>
    <p class="pro-info">Project Invitations</p>
    <div v-if="loading" class="text-center my-4">
      <span>Loading invitations...</span>
    </div>
    <div v-else>
      <div class="row" v-if="invitations.length">

        <div v-for="project in invitations" 
        class="col-md-5" 
        :key="project.id">

          <div class="card invitation border-secondary">
            <div class="card-header text-center">
              Project Name:
              <router-link :to="`/projects/'${project.slug}`">{{ project.name }}</router-link>
            </div>
            <div class="card-body mt-1 text-center">
              <p>Owner Name:
                <router-link :to="`/user/${project.owner.uuid}/profile`" 
                target="_blank">{{ project.owner.name }}
                </router-link>
              </p>
              <p class="text-center">
                <button class="btn btn-primary btn-sm" @click.prevent="becomeMember(project.slug)">Become Member</button>
                <button class="btn btn-danger btn-sm" @click.prevent="rejectInvitation(project.slug)">Ignore Invitation</button>
              </p>
            </div>
            <div class="card-footer">
              <p> 📨
                Invitation Received On: <b>{{ project.invitation_sent_at }}</b>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <h3>{{ serverMessage }}</h3>
      </div>
    </div>
  </div>
</template>

<script>


export default {
  data() {
    return {
      invitations: [],
      loading: false,
      serverMessage: '',
    };
  },
  created() {
    this.fetchInvitations();
  },
  methods: {
    async fetchInvitations() {
      this.loading = true;
      try {
        const {data} = await axios.get('/api/v1/me/invitations');
        this.invitations = data.invitations || [];
        if (data.message) {
          this.serverMessage = data.message;
        }
      } catch (error) {
        this.handleApiError(error, 'Failed to load invitations.');
      } finally {
        this.loading = false;
      }
    },
    async becomeMember(slug) {
      this.$Progress.start();
      try {
        const { data } = await axios.get(`/api/v1/projects/${slug}/accept-invitation`);
        this.$Progress.finish();
        this.$vToastify.success(data.message);

        this.invitations = this.invitations.filter(
          p => p.id !== data.project.id
        );
      } catch (error) {
        this.$Progress.fail();
        this.notifyError(error, 'Failed to accept the invitation. Try again.');
      }
    },
    async rejectInvitation(slug) {
      this.$Progress.start();
      try {
        const { data } = await axios.get(`/api/v1/projects/${slug}/reject/invitation`);
        this.$Progress.finish();
        this.$vToastify.info(data.message);
        
        this.invitations = this.invitations.filter(
          p => p.id !== data.project.id
        );
      } catch (error) {
        this.$Progress.fail();
        this.notifyError(error, 'Failed to reject the request. Try again.');
      }
    },
     notifyError(error, fallbackMsg) {
      const resp = error.response?.data || {};
      const msg =
        resp.message ||
        resp.error ||
        (resp.errors
          ? Object.values(resp.errors).flat().join(' ')
          : '') ||
        fallbackMsg;
      this.$vToastify.warning(msg);
    },
  },
}

</script>
<template>
  <div>
    <div v-if="!isSubscribed" class="alert alert-dark mt-2" role="alert">
      <b>Only subscribed users can access this feature.</b>
    </div>
    <slot v-else></slot>
  </div>
</template>

<script>
export default {
  computed: {
    isSubscribed() {
      return this.$store.state.subscribeUser.subscription.subscribed;
    },
  },
};
</script>

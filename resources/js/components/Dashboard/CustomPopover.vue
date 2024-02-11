<!-- PopoverContent.vue -->
<template>
  <div>
    <p>{{ activity.description }}</p>
    <router-link :to="{ name: 'YourRouteName', params: { id: activity.id } }">Go to Activity</router-link>
  </div>
</template>

<script>
export default {
  props: {
    activity: Object,
  },
};
</script>


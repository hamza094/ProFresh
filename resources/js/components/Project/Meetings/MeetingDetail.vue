<template>
  <li>
    <b>{{ label }}: </b>
    <slot>
      <span class="meeting_item">
        <span :class="statusBadgeClass">{{ value }}</span>
      </span>
    </slot>
  </li>
</template>

<script>
export default {
  props: {
    label: String,
    value: [String, Number],
    isEditing: Boolean,
  },
  computed: {
    statusBadgeClass() {
      return this.value === 'Started' ? 'badge badge-success' : '';
    },
  },
};
</script>

<style scoped>
/* your styles here */
</style>

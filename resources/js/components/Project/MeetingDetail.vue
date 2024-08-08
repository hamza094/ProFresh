<template>
  <li>
    <b>{{ label }}: </b>
    <slot>
      <span class="meeting_item">
      {{ value }}
    </span>
    </slot>
  </li>
</template>

<script>
export default {
  props: {
    label: String,
    value: [String,Number],
    isEditing: Boolean,
  },
};
</script>

<style scoped>
/* your styles here */
</style>
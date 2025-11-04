<template>
  <div class="form-group">
    <label :for="id" class="label-name">{{ label }}</label>
    <slot></slot>
    <span class="text-danger font-italic" v-if="error" v-text="error[0]"></span>
  </div>
</template>

<script>
export default {
  props: {
    id: { type: [String, Number], required: false },
    label: { type: String, required: true },
    // `error` can be an array of messages (from API), a string, or null
    error: { type: [Array, String, Object], default: null },
  },
};
</script>

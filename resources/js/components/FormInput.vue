<template>
  <div class="form-group">
    <label :for="id" class="label-name">{{ label }}</label>

    <input
      :type="type"
      :id="id"
      class="form-control"
      :name="name"
      :value="value"
      @input="$emit('input', $event.target.value)" />

    <span class="text-danger font-italic" v-if="error" v-text="error[0]"></span>
  </div>
</template>

<script>
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    id: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      default: '',
    },
    value: {
      type: [String, Number],
      default: '',
    },
    error: {
      type: Array,
      default: () => [],
    },
    type: {
      type: String,
      default: 'text',
    },
  },
};
</script>

<template>
  <div class="form-group">
    <label :for="id" class="label-name">{{ label }}</label>
    <slot></slot>
    <span class="text-danger font-italic" v-if="error" v-text="error[0]"></span>
  </div>
</template>

<script>
export default {
  props: ['id', 'label', 'error']
};
</script>
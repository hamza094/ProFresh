<template>
  <span class="feature-dropdown" @click="$emit('update:featurePop', !featurePop)">
    <span class="btn btn-light btn-sm"><i class="fa-solid fa-ellipsis-v"></i></span>
    <span class="feature-dropdown_item" v-show="featurePop">
      <slot></slot>
    </span>
  </span>
</template>

<script type="text/javascript">
export default {
  props: {
    featurePop: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

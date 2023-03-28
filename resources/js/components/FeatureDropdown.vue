<template>
  <span class="feature-dropdown" @click="featurePop = !featurePop">
    <span class="btn btn-light btn-sm"><i class="fas fa-ellipsis-v"></i></span>
    <span class="feature-dropdown_item" v-show="featurePop">
      <slot></slot>
    </span>
  </span>
</template>

<script type="text/javascript">
export default {
    props:['featurePop'],
    data() {
        return {

        };
    },

    methods: {



  }
}
</script>

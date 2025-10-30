<template>
  <div>
    <div
      class="modal fade"
      tabindex="-1"
      :class="{ show: show }"
      style="display: block"
      v-if="show"
      aria-modal="true"
      role="dialog"
      @click.self="$emit('cancel')">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="bi bi-exclamation-triangle me-2 text-warning" aria-hidden="true"></i>
              Disable Two-Factor Authentication
            </h5>
            <button type="button" class="btn-close" @click="$emit('cancel')" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="alert alert-warning" role="alert">
              <i class="bi bi-shield-x me-2" aria-hidden="true"></i>
              <strong>Security Warning:</strong> Disabling 2FA will make your account less secure.
            </div>
            <p class="mb-0">
              Are you sure you want to disable Two-Factor Authentication? This action cannot be undone.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('cancel')" :disabled="loading">Cancel</button>
            <button type="button" class="btn btn-danger" :disabled="loading" @click="$emit('confirm')">
              <span
                v-if="loading"
                class="spinner-border spinner-border-sm me-1"
                role="status"
                aria-hidden="true"></span>
              <i v-else class="bi bi-shield-x me-1" aria-hidden="true"></i>
              Disable 2FA
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Backdrop -->
    <div v-if="show" class="modal-backdrop fade show" @click="$emit('cancel')"></div>
  </div>
</template>

<script>
export default {
  name: 'Disable2FAConfirmModal',
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['confirm', 'cancel'],
  watch: {
    show(newVal) {
      if (newVal) {
        document.body.classList.add('modal-open');
      } else {
        document.body.classList.remove('modal-open');
      }
    },
  },
  mounted() {
    // Prevent body scroll when modal is open
    if (this.show) {
      document.body.classList.add('modal-open');
    }
  },
  beforeDestroy() {
    // Restore body scroll when component is destroyed
    document.body.classList.remove('modal-open');
  },
};
</script>

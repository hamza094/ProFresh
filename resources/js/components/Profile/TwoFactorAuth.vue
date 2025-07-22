<template>
  <div class="card mt-4 twofa-card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="mb-0">🔐 Two-Factor Authentication</h5>
      <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    </div>

    <div class="card-body" v-if="!loading">
      <!-- Stepper for setup -->
      <div v-if="isInProgress || isEnabled" class="mb-3">
        <div class="stepper d-flex align-items-center">
          <div :class="['step', isInProgress ? 'active' : 'completed']">1</div>
          <div class="step-label">Setup</div>
          <div class="step-line"></div>
          <div :class="['step', isEnabled ? 'active' : (isInProgress ? '' : 'disabled')]">2</div>
          <div class="step-label">Confirm</div>
        </div>
      </div>
      <!-- Error Alert -->
      <div v-if="error" class="alert alert-danger" aria-live="polite">{{ error }}</div>
      <!-- ✅ IF ENABLED -->
      <div v-if="isEnabled">
        <p class="text-success mb-2">✅ 2FA is <strong>enabled</strong> on your account.</p>
        <h6>Recovery Codes:</h6>
        <ul class="list-group mb-3">
          <li v-for="code in recoveryCodes" :key="code" class="list-group-item">{{ code }}</li>
        </ul>
        <div class="d-flex gap-2 flex-wrap">
          <button class="btn btn-warning btn-sm me-2" :disabled="regenerateLoading" @click="regenerateCodes" aria-label="Regenerate recovery codes">
            <span v-if="regenerateLoading" class="spinner-border spinner-border-sm mr-1" role="status" /> Regenerate
          </button>
          <button class="btn btn-danger btn-sm" :disabled="disableLoading" @click="disable2FA" aria-label="Disable 2FA">
            <span v-if="disableLoading" class="spinner-border spinner-border-sm mr-1" role="status" /> Disable
          </button>
        </div>
      </div>
      <!-- 🚧 IN PROGRESS -->
      <div v-else-if="isInProgress">
        <div v-if="qrCode" class="text-center my-3" v-html="qrCode"></div>
        <p class="text-muted">Two-Factor Authentication setup is <strong>in progress</strong>. Enter the code from your app.</p>
        <form @submit.prevent="verify2FA" class="mb-2">
          <input
            type="text"
            v-model="code"
            class="form-control mb-2"
            placeholder="Enter 6-digit code"
            maxlength="6"
            autocomplete="one-time-code"
            required
            aria-label="2FA code"
          />
          <div v-if="codeError" class="text-danger small mb-2">{{ codeError }}</div>
          <button class="btn btn-primary w-100" type="submit" :disabled="verifyLoading || !!codeError">
            <span v-if="verifyLoading" class="spinner-border spinner-border-sm mr-1" role="status" /> Verify
          </button>
        </form>
        <button class="btn btn-danger btn-sm w-100" :disabled="disableLoading" @click="disable2FA" aria-label="Cancel 2FA setup">
          <span v-if="disableLoading" class="spinner-border spinner-border-sm mr-1" role="status" /> Cancel
        </button>
      </div>
      <!-- 📴 DISABLED -->
      <div v-else>
        <p class="text-muted">Two-Factor Authentication is <strong>disabled</strong>.</p>
        <button class="btn btn-primary" @click="openModal" aria-label="Enable 2FA">🔒 Enable 2FA</button>
      </div>
    </div>
    <!-- 🔐 PASSWORD CONFIRMATION MODAL -->
    <modal name="ConfirmPassword" height="auto" :scrollable="true" width="40%" class="model-desin" :clickToClose="false">
      <div class="edit-border-top p-3">
        <div class="edit-border-bottom">
          <div class="panel-top_content d-flex justify-content-between align-items-center">
            <span class="panel-heading">Confirm your current password</span>
            <span class="panel-exit" role="button" @click.prevent="closeModal" aria-label="Close">x</span>
          </div>
        </div>
        <div class="panel-form">
          <form @submit.prevent="enable2FA">
            <input
              type="password"
              v-model="form.password"
              class="form-control mb-2"
              placeholder="Enter your current password"
              autocomplete="current-password"
              required
              aria-label="Current password"
            />
            <div class="d-flex justify-content-end gap-2">
              <button class="btn btn-secondary me-2" @click.prevent="closeModal">Cancel</button>
              <button class="btn btn-success" type="submit" :disabled="enableLoading">
                <span v-if="enableLoading" class="spinner-border spinner-border-sm mr-1" role="status" /> Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </modal>
  </div>
</template>

<script>
export default {
  name: "TwoFactorAuth",
  data() {
    return {
      status: "",
      qrCode: null,
      code: "",
      codeError: "",
      recoveryCodes: [],
      form: {
        password: "",
      },
      loading: false,
      verifyLoading: false,
      disableLoading: false,
      regenerateLoading: false,
      enableLoading: false,
      error: "",
    };
  },
  computed: {
    isEnabled() { return this.status === 'enabled'; },
    isInProgress() { return this.status === 'in_progress'; },
    isDisabled() { return !this.status || this.status === 'disabled'; }
  },
  mounted() {
    this.check2FAStatus();
    document.addEventListener('keydown', this.handleEscape);
  },
  beforeDestroy() {
    document.removeEventListener('keydown', this.handleEscape);
  },
  methods: {
    handleEscape(e) {
      if (e.key === 'Escape') {
        this.closeModal();
      }
    },
    openModal() {
      this.$modal.show("ConfirmPassword");
    },
    closeModal() {
      this.$modal.hide("ConfirmPassword");
    },
    validateCode() {
      this.code = this.code.replace(/[^0-9]/g, '').slice(0, 6);
      if (this.code.length > 0 && this.code.length < 6) {
        this.codeError = "Code must be 6 digits.";
      } else {
        this.codeError = "";
      }
    },
    extractError(e, fallback = "An error occurred.") {
      return e.response?.data?.errors?.code?.[0]
        || e.response?.data?.errors?.two_factor?.[0]
        || e.response?.data?.message
        || fallback;
    },
    resetState(loadingKey) {
      this.error = "";
      if (loadingKey) this[loadingKey] = true;
    },
    async handleApiCall(apiFn, args = [], onSuccess = () => {}, loadingKey = '') {
      this.error = "";
      if (loadingKey) this[loadingKey] = true;
      try {
        const res = await apiFn(...args);
        await onSuccess(res);
      } catch (e) {
        this.error = this.extractError(e);
      } finally {
        if (loadingKey) this[loadingKey] = false;
      }
    },
    async check2FAStatus() {
      await this.handleApiCall(
        () => axios.get("/api/v1/twofactor/fetch-user"),
        [],
        (res) => {
          this.status = res.data.status;
          if(this.status === 'in_progress'){
            this.qrCode = res.data.qr_code;
          }
        },
        'loading'
      );
    },
    async enable2FA() {
      await this.handleApiCall(
        () => axios.post("/api/v1/twofactor/setup", this.form),
        [],
        (res) => {
          this.status = res.data.status;
          this.qrCode = res.data.qr_code;
          this.$vToastify.success("2FA setup started.");
          this.closeModal();
          this.form.password = "";
        },
        'enableLoading'
      );
    },
    async verify2FA() {
      await this.handleApiCall(
        () => axios.post("/api/v1/twofactor/confirm", { code: this.code }),
        [],
        (res) => {
          this.recoveryCodes = res.data.recoveryCodes;
          this.status = res.data.status;
          this.qrCode = null;
          this.code = "";
          this.$vToastify.success("2FA successfully verified.");
        },
        'verifyLoading'
      );
    },
    async regenerateCodes() {
      await this.handleApiCall(
        () => axios.get("/api/v1/twofactor/recovery-codes"),
        [],
        (res) => {
          this.recoveryCodes = res.data.recoveryCodes;
          this.$vToastify.success("Recovery codes regenerated.");
        },
        'regenerateLoading'
      );
    },
    async disable2FA() {
      await this.handleApiCall(
        () => axios.delete("/api/v1/twofactor/disable"),
        [],
        (res) => {
          this.status = res.data.status;
          this.recoveryCodes = [];
          this.qrCode = null;
          this.code = "";
          this.$vToastify.success(res.data.message);
        },
        'disableLoading'
      );
    },
  },
};
</script>

<style scoped>
.twofa-card {
  max-width: 500px;
  margin: 0 auto;
}
.spinner-border {
  width: 1rem;
  height: 1rem;
  vertical-align: text-bottom;
}
.gap-2 {
  gap: 0.5rem;
}
.stepper {
  margin-bottom: 1rem;
}
.step {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  background: #e9ecef;
  color: #6c757d;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.1rem;
  margin-right: 0.5rem;
}
.step.active {
  background: #0d6efd;
  color: #fff;
}
.step.completed {
  background: #198754;
  color: #fff;
}
.step.disabled {
  background: #e9ecef;
  color: #adb5bd;
}
.step-label {
  margin-right: 1rem;
  font-size: 1rem;
  color: #6c757d;
}
.step-line {
  flex: 1;
  height: 2px;
  background: #dee2e6;
  margin-right: 1rem;
}
@media (max-width: 600px) {
  .model-desin {
    width: 90% !important;
    min-width: unset !important;
  }
}
</style>
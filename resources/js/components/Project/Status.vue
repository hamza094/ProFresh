<template>
  <div class="project-status-root">
    <div class="img-avatar">
      <div class="img-avatar_name">{{ projectInitial }}</div>
    </div>

    <div class="score-dropdown" ref="dropdown" :id="'score-dropdown-' + _uid">
      <!-- trigger -->
      <span
        role="button"
        tabindex="0"
        :aria-expanded="String(isPop)"
        :aria-controls="'score-dropdown-' + _uid"
        @click.stop="isPop = !isPop"
        class="score-point"
        :class="'score-point_' + status"
        @keydown.enter.prevent="isPop = !isPop"
        @keydown.space.prevent="isPop = !isPop"
      >
        {{ score }}
      </span>

      <!-- Enhanced menu with insights -->
      <div class="score-dropdown_item" v-show="isPop">
        <div class="score">
          <!-- Project Info Header -->
          <div class="score-content">
            <p class="score-content_para">
              <i class="far fa-clock"></i>
              The project started {{ start }}. Currently in its
              <b v-text="stagename()"></b> stage
            </p>
          </div>

          <!-- Inline Project Health Insight -->
          <div class="insights-section">
            <div class="insights-header d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom-0">
              <h5 class="mb-0 d-flex align-items-center">
                <i class="fas fa-heartbeat me-2"></i>
                Project Health
              </h5>
            </div>

            <div class="mt-2">
              <div v-if="healthLoading" class="d-flex align-items-center text-muted small py-1">
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status" aria-label="Loading"></div>
                <span>Loading health…</span>
              </div>
              <div v-else-if="healthError" class="text-danger small">{{ healthError }}</div>

              <div v-else-if="healthInsight" class="card insight-detail-card insight-detail-card_info mb-2">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                  <div class="d-flex align-items-center">
                    <div class="insight-icon health"><i class="fas fa-heartbeat"></i></div>
                    <h6 class="card-title mb-0 fw-semibold">{{ healthInsight.title || 'Health' }}</h6>
                  </div>
                  <span class="badge bg-success insight-badge">Health</span>
                </div>
                <div class="card-body py-2">
                  <div v-if="healthInsight.data" class="primary-value mb-2">
                    <span class="display-6 fw-bold text-dark">{{ formatHealthValue(healthInsight) }}</span>
                    <span class="fs-6 text-muted ms-1">%</span>
                  </div>
                  <p v-if="healthInsight.message" class="card-text text-muted small mb-0"><b>{{ healthInsight.message }}</b></p>
                </div>
              </div>

              <div class="insights-actions mt-2 text-end">
                <button class="btn-full-insights d-inline-flex align-items-center" @click.stop="openInsightsModal($event)">
                  <i class="fas fa-chart-bar"></i>
                  View Complete Insights
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Insights Modal -->
    <ProjectInsightsModal :project="project" />
  </div>
</template>

<script>
import ProjectInsightsModal from './Insights/ProjectInsightsModal.vue'
import ProjectInsightsMixin from '../../mixins/ProjectInsightsMixin.js'

export default {
  name: 'ProjectStatus',
  components: { ProjectInsightsModal },
  mixins: [ProjectInsightsMixin],

  props: {
    projectName: { type: String, default: '' },
    start: { type: String, default: '' },
    stage: { type: [Object, String, Number], default: null },
    completed: { type: Boolean, default: false },
    status: { type: String, default: '' },
    project: { type: Object, default: null }
  },

  data() {
    return {
      isPop: false,
      clickOutsideHandler: null,
      // Inline project health preview state
      healthLoading: false,
      healthError: null,
      healthInsight: null
    }
  },

  watch: {
    isPop: {
      handler(isOpen) {
        if (isOpen) {
          this.addClickOutsideListener()
          // Fetch health insight when dropdown opens
          if (this.project) {
            this.fetchHealth()
          }
        } else {
          this.removeClickOutsideListener()
        }
      }
    }
  },

  beforeDestroy() {
    this.removeClickOutsideListener()
  },

  methods: {
    stagename() {
      return this.project && this.project.stage ? this.project.stage.name : 'Unknown'
    },

    addClickOutsideListener() {
      if (this.clickOutsideHandler) return

      this.$nextTick(() => {
        this.clickOutsideHandler = (event) => {
          if (this.$refs.dropdown && !this.$refs.dropdown.contains(event.target)) {
            this.isPop = false
          }
        }

        document.addEventListener('click', this.clickOutsideHandler)
      })
    },

    removeClickOutsideListener() {
      if (!this.clickOutsideHandler) return

      document.removeEventListener('click', this.clickOutsideHandler)
      this.clickOutsideHandler = null
    },

    openInsightsModal(event) {
      if (event && event.stopPropagation) event.stopPropagation()

      if (!this.project) {
        console.warn('No project available for insights modal')
        return
      }

      this.isPop = false
      this.$modal.show('project-insights-modal', { project: this.project })
    },

    async fetchHealth() {
      this.healthLoading = true
      this.healthError = null
      this.healthInsight = null

      try {

  const result = await this.loadCurrentProjectInsights(['health'])
  if (!result || !result.success) throw new Error('Failed to load health insight')

  const insights = Array.isArray(result.insights) ? result.insights : []
  this.healthInsight = insights[0] || null
      } catch (e) {
        this.healthError = (e && e.message) ? e.message : 'Failed to load health insight'
      } finally {
        this.healthLoading = false
      }
    },

    formatHealthValue(insight) {
      if (!insight || !insight.data) return 'N/A'
      const { value, percentage } = insight.data
      if (typeof percentage === 'number') return Math.round(percentage)
      if (typeof value === 'number') return Math.round(value)
      return 'N/A'
    }
  },

  computed: {
    projectInitial() {
      return (this.projectName || '').substring(0, 1).toUpperCase()
    }
    ,
    score() {
      // safe fallback if project doesn't provide a score
      if (this.project && (this.project.score != null)) return this.project.score
      return ''
    }
  }
}
</script>

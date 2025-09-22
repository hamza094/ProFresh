<template>
  <modal 
    name="project-insights-modal" 
    :adaptive="true"
    :scrollable="true"
    :reset="true"
    width="90%"
    max-width="1200px"
    height="auto"
    max-height="90%"
    @before-open="handleBeforeOpen"
    @closed="handleClosed"
  >
    <div class="insights-modal">
      <!-- Modal Header -->
      <div class="insights-modal-header border-bottom bg-light p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex align-items-center">
            <div class="project-avatar rounded-circle d-flex align-items-center justify-content-center me-3">
              <span>{{ (projectName || '').substring(0, 1).toUpperCase() }}</span>
            </div>
            <div>
              <h3 class="h4 mb-0 text-dark fw-bold">{{ projectName || 'Project Insights' }}</h3>
              <p class="text-muted small mb-0">Comprehensive project analysis and recommendations</p>
            </div>
          </div>
          <button @click="closeModal" class="btn-close" aria-label="Close"></button>
        </div>
        
        <!-- Section Filters -->
        <div>
          <InsightFilters
            :sections="availableSections"
            :active-sections="activeSections"
            @filter-change="handleFilterChange"
          />
        </div>
      </div>

      <!-- Modal Body -->
      <div class="insights-modal-body flex-grow-1 p-4 overflow-auto">
        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-primary mb-3" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="text-muted">Loading project insights...</p>
        </div>

        <div v-else-if="error" class="text-center py-5">
          <i class="fas fa-exclamation-triangle display-4 text-danger mb-3"></i>
          <h4 class="text-danger">Unable to Load Insights</h4>
          <p class="text-muted">{{ error }}</p>
          <button @click="fetchInsights" class="btn btn-primary mt-2">
            <i class="fas fa-redo me-2"></i> Retry
          </button>
        </div>

        <div v-else-if="insights.length === 0" class="text-center py-5">
          <i class="fas fa-chart-line display-4 text-muted mb-3"></i>
          <h4 class="text-muted">No Insights Available</h4>
          <p class="text-muted">No insights match your current filter selection.</p>
        </div>

        <div v-else class="insights-content">
          <!-- Quick Stats Overview -->
          <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3" v-if="quickStats.health !== null">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                  <div class="stat-icon health rounded-circle d-flex align-items-center justify-content-center me-3">
                    <i class="fas fa-heartbeat"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ quickStats.health }}%</div>
                    <small class="text-muted">Project Health</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3" v-if="quickStats.completion !== null">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                  <div class="stat-icon completion rounded-circle d-flex align-items-center justify-content-center me-3">
                    <i class="fas fa-tasks"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ quickStats.completion }}%</div>
                    <small class="text-muted">Completion</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3" v-if="quickStats.overdue !== null">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                  <div class="stat-icon overdue rounded-circle d-flex align-items-center justify-content-center me-3">
                    <i class="fas fa-clock"></i>
                  </div>
                  <div>
                    <div class="h3 mb-0 fw-bold text-dark">{{ quickStats.overdue }}</div>
                    <small class="text-muted">Overdue Tasks</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Detailed Insights Grid -->
          <div>
            <h4 class="h5 d-flex align-items-center mb-4">
              <i class="fas fa-analytics me-2"></i>
              Detailed Analysis
            </h4>
            <div class="row">
              <div 
                v-for="insight in prioritizedInsights" 
                :key="insight.title"
                class="col-xl-6 col-lg-12 mb-4"
              >
                <div class="card h-100 insight-detail-card border-start border-4" :class="'insight-detail-card_' + insight.type">
                  <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                      <div class="insight-icon" :class="getInsightIconClass(insight)">
                        <i :class="getInsightIcon(insight)"></i>
                      </div>
                      <h5 class="card-title mb-0 fw-semibold">{{ insight.title }}</h5>
                    </div>
                    <span class="badge" :class="getBootstrapBadgeClass(insight.type)">
                      {{ getTypeLabel(insight.type) }}
                    </span>
                  </div>

                  <div class="card-body">
                    <div v-if="insight.data" class="mb-3">
                      <div class="primary-value">
                        <span class="display-6 fw-bold text-dark">{{ formatValue(insight) }}</span>
                        <span v-if="getValueUnit(insight)" class="fs-5 text-muted ms-1">{{ getValueUnit(insight) }}</span>
                      </div>
                    </div>

                    <p class="card-text text-muted">{{ insight.message }}</p>

                    <!-- Enhanced metadata display -->
                    <div v-if="hasMetadata(insight)" class="insight-metadata d-flex flex-wrap gap-3 mb-3">
                      <div v-if="insight.data.trend" class="metadata-item d-flex align-items-center">
                        <div class="metadata-icon trend">
                          <i class="fas fa-chart-line"></i>
                        </div>
                        <span>{{ insight.data.trend }}</span>
                      </div>
                      <div v-if="insight.data.threshold" class="metadata-item d-flex align-items-center">
                        <div class="metadata-icon target">
                          <i class="fas fa-bullseye"></i>
                        </div>
                        <span>{{ insight.data.threshold }}{{ getValueUnit(insight) }}</span>
                      </div>
                      <div v-if="insight.data.score" class="metadata-item d-flex align-items-center">
                        <div class="metadata-icon score">
                          <i class="fas fa-star"></i>
                        </div>
                        <span>{{ insight.data.score }}/10</span>
                      </div>
                    </div>

                    <!-- Recommendations -->
                    <div v-if="insight.recommendations && insight.recommendations.length" class="recommendations bg-light rounded p-3">
                      <h6 class="d-flex align-items-center mb-2 fw-semibold">
                        <i class="fas fa-lightbulb me-2"></i> Recommendations
                      </h6>
                      <ul class="mb-0 ps-3">
                        <li v-for="(rec, index) in insight.recommendations" :key="index" class="small text-muted mb-1">
                          {{ rec }}
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="insights-modal-footer d-flex justify-content-between align-items-center p-3 border-top bg-light" v-if="!loading && !error">
        <div>
          <small v-if="metadata" class="text-muted d-flex align-items-center">
            <i class="far fa-clock me-2"></i>
            Generated {{ formatTimestamp(metadata.generated_at) }}
          </small>
        </div>
        <div class="d-flex gap-2">
          <button @click="refreshInsights" class="btn btn-primary btn-sm">
            <i class="fas fa-sync me-2"></i> Refresh
          </button>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import ProjectInsightsService from '../../../services/ProjectInsightsService.js'
import InsightFilters from './InsightFilters.vue'

// Constants
const PRIORITY_ORDER = { critical: 1, warning: 2, info: 3, success: 4 }
const ICON_MAP = {
  health: 'fas fa-heartbeat',
  completion: 'fas fa-tasks',
  overdue: 'fas fa-exclamation-triangle',
  engagement: 'fas fa-users',
  collaboration: 'fas fa-handshake',
  risk: 'fas fa-shield-alt',
  stage: 'fas fa-project-diagram',
  progress: 'fas fa-chart-line',
  abandonment: 'fas fa-archive'
}
const TYPE_ICONS = {
  critical: 'fas fa-exclamation-triangle',
  warning: 'fas fa-exclamation-circle',
  success: 'fas fa-check-circle',
  info: 'fas fa-info-circle'
}
const TYPE_LABELS = {
  critical: 'Critical',
  warning: 'Warning',
  success: 'Good',
  info: 'Info',
  health: 'Health'
}
const BADGE_CLASSES = {
  critical: 'bg-danger',
  warning: 'bg-warning text-dark',
  success: 'bg-success',
  info: 'bg-info',
  health: 'bg-success'
}

export default {
  name: 'ProjectInsightsModal',
  components: {
    InsightFilters
  },
  props: {
    project: { type: Object, required: true }
  },
  data() {
    return {
      loading: false,
      error: null,
      insights: [],
      metadata: null,
      activeSections: ['all'],
      availableSections: ProjectInsightsService.getAvailableSections(),
      quickStats: { health: null, completion: null, overdue: null }
    }
  },
  computed: {
    projectName() {
      return this.project?.name || this.project?.title || 'Unknown Project'
    },
    
    projectSlug() {
      return this.project?.slug || this.project?.id
    },
    
    prioritizedInsights() {
      return [...this.insights].sort((a, b) => (PRIORITY_ORDER[a.type] || 5) - (PRIORITY_ORDER[b.type] || 5))
    }
  },
  methods: {
    async handleBeforeOpen(event) {
      const modalProject = event.params?.project || this.project
      
      if (!modalProject) return
      
      this.$emit('project-changed', modalProject)
      await Promise.all([this.fetchInsights(), this.fetchQuickStats()])
    },

    handleClosed() {
      Object.assign(this, {
        error: null,
        insights: [],
        metadata: null,
        activeSections: ['all']
      })
    },

    async fetchInsights() {
      if (!this.projectSlug) {
        this.error = 'No project specified'
        return
      }

      this.loading = true
      this.error = null

      try {
        const sections = this.activeSections.includes('all') ? ['all'] : this.activeSections
        const result = await ProjectInsightsService.getInsights(this.projectSlug, sections)

        if (!result.success) {
          throw new Error('Failed to load insights')
        }

        this.insights = result.insights || []
        this.metadata = result.metadata
      } catch (error) {
        this.error = error.message || 'Failed to load project insights'
      } finally {
        this.loading = false
      }
    },

    async fetchQuickStats() {
      if (!this.projectSlug) return

      try {
        this.quickStats = await ProjectInsightsService.getQuickStats(this.projectSlug)
      } catch (error) {
        // Silently fail - quick stats are non-critical
      }
    },

    async handleFilterChange(newSections) {
      this.activeSections = [...newSections]
      await this.fetchInsights()
    },

    async refreshInsights() {
      await Promise.all([this.fetchInsights(), this.fetchQuickStats()])
    },

    closeModal() {
      this.$modal.hide('project-insights-modal')
    },

    getInsightIcon(insight) {
      // Match by type first
      if (ICON_MAP[insight.type]) return ICON_MAP[insight.type]

      // Match by title keywords
      const title = insight.title.toLowerCase()
      const matchedIcon = Object.entries(ICON_MAP).find(([key]) => title.includes(key))
      if (matchedIcon) return matchedIcon[1]

      return TYPE_ICONS[insight.type] || 'fas fa-chart-bar'
    },

    getInsightIconClass(insight) {
      // Determine icon type for CSS class
      const title = insight.title.toLowerCase()
      
      // Check for specific keywords first
      for (const [key] of Object.entries(ICON_MAP)) {
        if (insight.type === key || title.includes(key)) {
          return key
        }
      }
      
      // Fall back to insight type
      return insight.type || 'info'
    },

    getTypeLabel(type) {
      return TYPE_LABELS[type] || type.charAt(0).toUpperCase() + type.slice(1)
    },

    getBootstrapBadgeClass(type) {
      return `${BADGE_CLASSES[type] || 'bg-secondary'} insight-badge`
    },

    formatValue(insight) {
      if (!insight.data) return '-'

      const { value, count } = insight.data
      
      if (value !== undefined) {
        return this.isPercentage(insight) ? Math.round(value) : 
               typeof value === 'number' ? Math.round(value * 100) / 100 : value
      }
      
      if (count !== undefined) return count
      
      return '-'
    },

    getValueUnit(insight) {
      if (!insight.data) return ''
      if (insight.data.unit) return insight.data.unit
      if (this.isPercentage(insight)) return '%'
      return ''
    },

    isPercentage(insight) {
      if (!insight) return false
      const title = insight.title.toLowerCase()
      return ['health', 'completion', 'progress', 'percent'].some(key => title.includes(key))
    },

    hasMetadata(insight) {
      if (!insight.data) return false
      return !!(insight.data.trend || insight.data.threshold || insight.data.score)
    },

    formatTimestamp(timestamp) {
      if (!timestamp) return 'Unknown'
      
      try {
        return new Date(timestamp).toLocaleString()
      } catch {
        return 'Unknown'
      }
    },

    // exportInsights removed per request
  }
}
</script>


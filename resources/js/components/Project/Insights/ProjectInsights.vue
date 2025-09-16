<template>
  <div class="project-insights w-100">
    <div v-if="loading" class="text-center py-4">
      <div class="spinner-border text-primary mb-3" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="text-muted mb-0">Loading insights...</p>
    </div>
    <div v-else-if="error" class="text-center py-4 text-danger">
      <i class="fas fa-exclamation-triangle display-6 mb-3"></i>
      <p class="mb-3">{{ error }}</p>
      <button @click="fetchInsights" class="btn btn-sm btn-primary">
        <i class="fas fa-redo me-2"></i>Retry
      </button>
    </div>
    <div v-else class="insights-content animate__animated animate__fadeIn animate__faster">
      <div class="row g-1">
        <div v-for="insight in insights" :key="insight.id || insight.title" class="col-12">
          <InsightCard :insight="insight" :compact="true"></InsightCard>
        </div>
      </div>
      <div v-if="insights.length === 0" class="text-center py-4 text-muted">
        <i class="fas fa-chart-line display-6 mb-3 opacity-50"></i>
        <p class="mb-0">No insights available</p>
      </div>
    </div>
  </div>
</template>

<script>
import InsightCard from './InsightCard.vue'
import ProjectInsightsService from '../../../services/ProjectInsightsService.js'

// Constants & helpers (module scope avoids per-instance recreation)
const CRITICAL_TYPES = ['health', 'overdue', 'risk', 'critical', 'warning']
const PRIORITIES = { critical: 1, warning: 2, info: 3, success: 4 }

// Predicate: is an insight critical enough for compact mode
function isCritical(insight) {
  if (!insight || !insight.title) return false
  const title = String(insight.title).toLowerCase()
  const type = String(insight.type || '').toLowerCase()
  const { data, priority } = insight
  return (
    CRITICAL_TYPES.some(ct => title.includes(ct) || type === ct) ||
    priority === 'critical' ||
    priority === 'high' ||
    (title.includes('health') && data && typeof data.value === 'number' && data.value < 70) ||
    (title.includes('overdue') && data && Number(data.count) > 0) ||
    (title.includes('risk') && type !== 'success')
  )
}

export default {
  name: 'ProjectInsights',
  components: { InsightCard },
  props: {
    project: { type: Object, required: true },
    initialSections: { type: Array, default: () => ['all'] },
  },
  data() {
    return {
      loading: false,
      error: null,
      insights: []
    }
  },
  created() {
    this.fetchInsights()
  },
  computed: {
    projectSlug() {
       return (this.project && (this.project.slug || this.project.id)) || null 
      }
  },
  watch: {
    project: { handler()
       { this.project && this.fetchInsights() 

       }, immediate: true }
  },
  methods: {
    async fetchInsights() {
      if (!this.projectSlug) return

      this.loading = true
      this.error = null

      try {
        const sections = Array.isArray(this.initialSections) ? this.initialSections : ['all']

        const result = await ProjectInsightsService.getInsights(this.projectSlug, sections)

        if (!result || !result.success) throw new Error((result && result.message) || 'API returned unsuccessful response')

        // Process on fetch: filter critical, sort by priority, limit to 3
        const incoming = Array.isArray(result.insights) ? result.insights : []
        this.insights = incoming
          .filter(isCritical)
          .sort((a, b) => this.getInsightPriority(a) - this.getInsightPriority(b))
          .slice(0, 3)

      } catch (error) {
        this.error = (error && error.message) || 'Failed to load project insights'
      } finally {
        this.loading = false
      }
    },
    getInsightPriority(insight) {
      if (!insight || typeof insight.type !== 'string') return 5
      return PRIORITIES[insight.type] || 5
    },

  }
}
</script>



<style scoped>
/* Fallback fade-in animation if Animate.css is not available */
.insights-content {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>

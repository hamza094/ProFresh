// Icons for severity/notice types (backend guarantees `type`)
const ICON_BY_TYPE = {
  critical: 'fas fa-exclamation-triangle',
  warning: 'fas fa-exclamation-circle',
  success: 'fas fa-check-circle',
  info: 'fas fa-info-circle'
}

// Human labels for severity types
const LABEL_BY_TYPE = {
  critical: 'Critical',
  warning: 'Warning',
  success: 'Good',
  info: 'Info'
}

// Bootstrap badge classes per severity type
const BADGE_CLASS_BY_TYPE = {
  critical: 'bg-danger',
  warning: 'bg-warning text-dark',
  success: 'bg-success',
  info: 'bg-info'
}

function toLower(value) { return String(value || '').toLowerCase() }
function capitalize(value) { value = String(value || ''); return value ? value.charAt(0).toUpperCase() + value.slice(1) : '' }

function typeKeyOf(insight) {
  return toLower(insight && insight.type) || 'info'
}

// Treat numeric values as percentages by default, unless unit provided
function isPercentBased(insight) {
  const data = insight && insight.data
  if (!data) return false
  if (data.unit) return data.unit === '%'
  return typeof data.value === 'number' || typeof data.percentage === 'number'
}

export default {
  methods: {
    getInsightIcon(insight) {
      const key = typeKeyOf(insight)
      return ICON_BY_TYPE[key] || 'fas fa-chart-bar'
    },
    getInsightIconClass(insight) {
      return typeKeyOf(insight)
    },
    getTypeLabel(type) {
      const key = toLower(type)
      return LABEL_BY_TYPE[key] || capitalize(key || 'info')
    },
    getBootstrapBadgeClass(type) {
      const key = toLower(type)
      return (BADGE_CLASS_BY_TYPE[key] || 'bg-secondary') + ' insight-badge'
    },
    getInsightMessage(insight) {
      return insight ? (insight.message || insight.description || '') : ''
    },
    formatValue(insight) {
      const data = insight && insight.data
      if (!data) return '-'
  if (typeof data.value === 'number') return isPercentBased(insight) ? Math.round(data.value) : Math.round(data.value * 100) / 100
      if (typeof data.count === 'number') return data.count
      if (typeof data.percentage === 'number') return Math.round(data.percentage)
      return '-'
    },
    getValueUnit(insight) {
      const data = insight && insight.data
      if (!data) return ''
      return data.unit || (isPercentBased(insight) ? '%' : '')
    },
    isPercentage(insight) { // keep method name for backward compatibility
      return isPercentBased(insight)
    },
    hasMetadata(insight) {
      const data = insight && insight.data
      return !!(data && (data.trend || data.threshold || data.score))
    }
  }
}

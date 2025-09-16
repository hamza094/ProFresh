/**
 * ProjectInsights Mixin
 * 
 * Provides common functionality for components that need to work with project insights
 */

import ProjectInsightsService from '../services/ProjectInsightsService.js'

export default {
  data() {
    return {
      projectInsightsLoading: false,
      projectInsightsError: null,
      projectInsightsCache: new Map()
    }
  },
  
  methods: {
    /**
     * Load insights for a project with caching
     * @param {string|object} project - Project slug/id or project object
     * @param {array} sections - Sections to fetch
     * @param {boolean} useCache - Whether to use cached data
     * @returns {Promise}
     */
    async loadProjectInsights(project, sections = ['all'], useCache = true) {
      const projectSlug = typeof project === 'string' ? project : (project?.slug || project?.id)
      const cacheKey = `${projectSlug}-${sections.join(',')}`
      
      // Return cached data if available and not expired (5 minutes)
      if (useCache && this.projectInsightsCache.has(cacheKey)) {
        const cached = this.projectInsightsCache.get(cacheKey)
        const isExpired = Date.now() - cached.timestamp > 300000 // 5 minutes
        
        if (!isExpired) {
          return cached.data
        }
      }
      
      this.projectInsightsLoading = true
      this.projectInsightsError = null
      
      try {
        const result = await ProjectInsightsService.getInsights(projectSlug, sections)
        
        // Cache the result
        this.projectInsightsCache.set(cacheKey, {
          data: result,
          timestamp: Date.now()
        })
        
        return result
      } catch (error) {
        this.projectInsightsError = error.message
        throw error
      } finally {
        this.projectInsightsLoading = false
      }
    },
    
    /**
     * Get quick stats for dashboard display
     * @param {string|object} project 
     * @returns {Promise}
     */
    async getProjectQuickStats(project) {
      const projectSlug = typeof project === 'string' ? project : (project?.slug || project?.id)
      
      try {
        return await ProjectInsightsService.getQuickStats(projectSlug)
      } catch (error) {
        console.error('Error fetching quick stats:', error)
        return { completion: 0, health: 0, overdue: 0 }
      }
    },
    
    /**
     * Clear insights cache for a project
     * @param {string} projectSlug 
     */
    clearProjectInsightsCache(projectSlug = null) {
      if (projectSlug) {
        // Clear specific project cache
        for (const key of this.projectInsightsCache.keys()) {
          if (key.startsWith(projectSlug)) {
            this.projectInsightsCache.delete(key)
          }
        }
      } else {
        // Clear all cache
        this.projectInsightsCache.clear()
      }
    },
    
    /**
     * Format insight value for display
     * @param {object} insight 
     * @returns {string}
     */
    formatInsightValue(insight) {
      if (!insight?.data) return 'N/A'
      
      const { value, count, percentage, currency } = insight.data
      
      if (percentage !== undefined) {
        return `${Math.round(percentage)}%`
      }
      
      if (currency !== undefined) {
        return new Intl.NumberFormat('en-US', {
          style: 'currency',
          currency: 'USD'
        }).format(currency)
      }
      
      if (value !== undefined) {
        if (insight.type === 'percentage' || insight.title.toLowerCase().includes('percent')) {
          return `${Math.round(value)}%`
        }
        
        return typeof value === 'number' ? Math.round(value).toLocaleString() : value
      }
      
      if (count !== undefined) {
        return count.toLocaleString()
      }
      
      return 'N/A'
    },
    
    /**
     * Get insight priority for sorting
     * @param {object} insight 
     * @returns {number}
     */
    getInsightPriority(insight) {
      const priorityMap = {
        'critical': 1,
        'high': 2,
        'warning': 3,
        'medium': 4,
        'info': 5,
        'low': 6,
        'success': 7
      }
      
      return priorityMap[insight.priority] || priorityMap[insight.type] || 8
    },
    
    /**
     * Get insight icon based on type
     * @param {object} insight 
     * @returns {string}
     */
    getInsightIcon(insight) {
      const iconMap = {
        'completion': 'fas fa-tasks',
        'health': 'fas fa-heartbeat',
        'overdue': 'fas fa-clock',
        'engagement': 'fas fa-users',
        'collaboration': 'fas fa-handshake',
        'risk': 'fas fa-exclamation-triangle',
        'stage': 'fas fa-project-diagram',
        'progress': 'fas fa-chart-line',
        'budget': 'fas fa-dollar-sign',
        'time': 'fas fa-hourglass-half',
        'quality': 'fas fa-check-circle'
      }
      
      // Try to match by type first, then by title keywords
      if (iconMap[insight.type]) {
        return iconMap[insight.type]
      }
      
      const title = insight.title.toLowerCase()
      for (const [key, icon] of Object.entries(iconMap)) {
        if (title.includes(key)) {
          return icon
        }
      }
      
      // Default based on priority/type
      const defaultIcons = {
        'critical': 'fas fa-exclamation-triangle',
        'warning': 'fas fa-exclamation-circle',
        'success': 'fas fa-check-circle',
        'info': 'fas fa-info-circle'
      }
      
      return defaultIcons[insight.priority] || defaultIcons[insight.type] || 'fas fa-chart-bar'
    }
  },
  
  beforeDestroy() {
    // Clean up cache when component is destroyed
    this.projectInsightsCache.clear()
  }
}

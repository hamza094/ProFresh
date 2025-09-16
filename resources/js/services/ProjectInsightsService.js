/**
 * Project Insights API Service
 * 
 * Provides interface for interacting with the Laravel Project Insights API
 */

class ProjectInsightsService {
  constructor() {
    this.baseUrl = '/api/v1'
  }

  /**
   * Get insights for a project what
   * @param {string} projectSlug - Project slug or ID
   * @param {array} sections - Array of sections to fetch
   * @returns {Promise}
   */
  async getInsights(projectSlug, sections) {
    if (!projectSlug) {
      throw new Error('Project identifier is required')
    }
    
    try {
      const params = new URLSearchParams()
      
      // Add sections as query parameters
      if (Array.isArray(sections)) {
        sections.forEach(section => params.append('sections[]', section))
      }
      
      // Note: headers removed — the client already configures default headers elsewhere
  const encodedSlug = encodeURIComponent(String(projectSlug))
  const url = `${this.baseUrl}/projects/${encodedSlug}/insights${params.toString() ? `?${params.toString()}` : ''}`
  const response = await axios.get(url)
      
      // Handle Laravel API Resource response format
      const body = response.data || {}
      if (body.success && body.data) {
        return {
          success: true,
          insights: Array.isArray(body.data.insights) ? body.data.insights : [],
          metadata: {
            project: body.data.project_name || null,
            project_id: body.data.project_id || null,
            sections: body.data.sections_requested || (Array.isArray(sections) ? sections : []),
            generated_at: body.data.generated_at || null
          }
        }
      }

      throw new Error(body.message || 'Invalid API response format')
    } catch (error) {
      // Normalize axios error object
      const resp = error?.response
      if (resp && resp.status) {
        const status = resp.status
        const msg = resp.data?.message || resp.statusText || 'API error'

        if (status === 403) {
          throw new Error('Access denied: insufficient permissions')
        }
        if (status === 404) {
          throw new Error('Project not found or insights not available')
        }
        if (status === 422) {
          throw new Error(msg)
        }

        throw new Error(`API Error (${status}): ${msg}`)
      }

      const msg = error?.message || 'Unknown error'
      if (msg.includes('Network Error')) {
        throw new Error('Network error: please check your connection')
      }

      throw new Error(`Failed to fetch project insights: ${msg}`)
    }
  }

  /**
   * Get a specific insight section
   * @param {string} projectSlug 
   * @param {string} section 
   * @returns {Promise}
   */
  async getSingleInsight(projectSlug, section) {
    return this.getInsights(projectSlug, [section])
  }

  /**
   * Get quick stats for dashboard display
   * @param {string} projectSlug 
   * @returns {Promise}
   */
  async getQuickStats(projectSlug) {
    try {
      const result = await this.getInsights(projectSlug, ['completion', 'health', 'overdue'])
      if (!result || !result.success) return { completion: 0, health: 0, overdue: 0 }

      return {
        completion: this.extractValue(result.insights, 'completion', 0),
        health: this.extractValue(result.insights, 'health', 0),
        overdue: this.extractValue(result.insights, 'overdue', 0)
      }
    } catch (error) {
      // Quick stats are non-critical; return zeros on any failure
      return { completion: 0, health: 0, overdue: 0 }
    }
  }

  /**
   * Extract a specific value from insights array
   * @param {array} insights 
   * @param {string} type 
   * @param {any} defaultValue 
   * @returns {any}
   */
  extractValue(insights, type, defaultValue) {
    if (!Array.isArray(insights) || !type) return defaultValue

    const lowered = type.toLowerCase()
    const insight = insights.find(i => {
      if (!i) return false
      const title = (i.title || '').toLowerCase()
      return i.type === lowered || title.includes(lowered)
    })

    if (!insight || !insight.data) return defaultValue

    if (typeof insight.data.value === 'number') return Math.round(insight.data.value)
    if (typeof insight.data.count === 'number') return insight.data.count

    return defaultValue
  }

  /**
   * Get available sections
   * @returns {array}
   */
  getAvailableSections() {
    return [
      { key: 'all', label: 'All', icon: 'fas fa-th' },
      { key: 'completion', label: 'Completion', icon: 'fas fa-tasks' },
      { key: 'health', label: 'Health', icon: 'fas fa-heartbeat' },
      { key: 'overdue', label: 'Overdue', icon: 'fas fa-clock' },
      { key: 'engagement', label: 'Team', icon: 'fas fa-users' },
      { key: 'collaboration', label: 'Collaboration', icon: 'fas fa-handshake' },
      { key: 'risk', label: 'Risk', icon: 'fas fa-exclamation-triangle' },
      { key: 'stage', label: 'Stage', icon: 'fas fa-project-diagram' },
      { key: 'progress', label: 'Progress', icon: 'fas fa-chart-line' }
    ]
  }
}

// Export singleton instance
export default new ProjectInsightsService()

// Also export the class for additional usage
export { ProjectInsightsService }

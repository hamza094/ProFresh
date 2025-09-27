import axios from 'axios'
import { normalizeSectionsForRequest } from '../utils/insightsSections.js'
const BASE_URL = '/api/v1'

const AVAILABLE_SECTIONS = [
  { key: 'all', label: 'All', icon: 'fas fa-th' },
  { key: 'health', label: 'Health', icon: 'fas fa-heartbeat' },
  { key: 'task-health', label: 'Task Health', icon: 'fas fa-tasks' },
  { key: 'collaboration', label: 'Collaboration', icon: 'fas fa-handshake' },
  { key: 'risk', label: 'Risk', icon: 'fas fa-exclamation-triangle' },
  { key: 'stage', label: 'Stage', icon: 'fas fa-project-diagram' }
]

// Extract a concise, user-friendly error message from an axios error
function extractErrorMessage(error) {
  const resp = error && error.response
  if (!resp || resp.status !== 422) {
    return 'An error occurred. Please try again later.'
  }
  const data = resp.data || {}
  if (data.message) return String(data.message)
  const first = data.errors && Object.values(data.errors)[0]
  return (Array.isArray(first) ? first[0] : first) || 'Validation error'
}
/**
 * Project Insights API Service
 * 
 * Provides interface for interacting with the Laravel Project Insights API
 */

class ProjectInsightsService {
  constructor() {}

  /**
   * Get insights for a project
   * @param {string} projectSlug - Project slug or ID
   * @param {array} sections - Array of sections to fetch
   * @returns {Promise}
   */
  async getInsights(projectSlug, sections) {
    if (!projectSlug) throw new Error('Project identifier is required')

    try {
      // Normalize allowed sections; omit query when none
      const normalized = normalizeSectionsForRequest(sections)

      const params = normalized.length
        ? new URLSearchParams(normalized.map(s => ['sections[]', s]))
        : null

      const slug = encodeURIComponent(String(projectSlug))
      const query = params ? `?${params.toString()}` : ''
      const url = `${BASE_URL}/projects/${slug}/insights${query}`

      const { data } = await axios.get(url)
      const d = data && data.data
      if (data && data.success && d) {
        const { project_name, project_id, sections_requested, generated_at } = d
        const insights = Array.isArray(d.insights) ? d.insights : []
        return {
          success: true,
          insights,
          metadata: {
            project: project_name ?? null,
            project_id: project_id ?? null,
            sections: Array.isArray(sections_requested) ? sections_requested : normalized,
            generated_at: generated_at ?? null
          }
        }
      }

      throw new Error('An error occurred. Please try again later.')
    } catch (error) {
      throw new Error(extractErrorMessage(error))
    }
  }

  /**
   * Get available sections
   * @returns {array}
   */
  getAvailableSections() {
    // Provide only backend-supported sections; keep an 'all' UI option that maps to no param
    return AVAILABLE_SECTIONS
  }
}

// Export singleton instance
export default new ProjectInsightsService()

// Also export the class for additional usage
export { ProjectInsightsService }

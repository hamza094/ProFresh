import axios from 'axios';
import { normalizeSectionsForRequest } from '../utils/insightsSections.js';
const BASE_URL = '';

const AVAILABLE_SECTIONS = [
  { key: 'all', label: 'All', icon: 'fa-solid fa-th' },
  { key: 'health', label: 'Health', icon: 'fa-solid fa-heartbeat' },
  { key: 'task-health', label: 'Task Health', icon: 'fa-solid fa-tasks' },
  { key: 'collaboration', label: 'Collaboration', icon: 'fa-solid fa-handshake' },
  { key: 'risk', label: 'Risk', icon: 'fa-solid fa-exclamation-triangle' },
  { key: 'stage', label: 'Stage', icon: 'fa-solid fa-project-diagram' },
];

// Extract a concise, user-friendly error message from an axios error
function extractErrorMessage(error) {
  const resp = error && error.response;
  if (resp?.status !== 422) {
    return 'An error occurred. Please try again later.';
  }
  const data = resp.data || {};
  if (data.message) return String(data.message);
  const first = data.errors && Object.values(data.errors)[0];
  return (Array.isArray(first) ? first[0] : first) || 'Validation error';
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
    if (!projectSlug) throw new Error('Project identifier is required');

    try {
      // Normalize allowed sections; omit query when none
      const normalized = normalizeSectionsForRequest(sections);

      const params = normalized.length ? new URLSearchParams(normalized.map((s) => ['sections[]', s])) : null;

      const slug = encodeURIComponent(String(projectSlug));
      const query = params ? `?${params.toString()}` : '';
      const url = `${BASE_URL}/projects/${slug}/insights${query}`;

      const { data: resp } = await axios.get(url);

      // Expect flattened API response shape from ProjectInsightsResource:
      // { success, project_id, project_name, insights, generated_at, sections_requested, message }
      if (resp?.success) {
        const insights = Array.isArray(resp.insights) ? resp.insights : [];
        const project_id = resp.project_id ?? null;
        const project_name = resp.project_name ?? null;
        const sections_requested = Array.isArray(resp.sections_requested) ? resp.sections_requested : normalized;
        const generated_at = resp.generated_at ?? null;

        return {
          success: true,
          insights,
          project_id,
          project_name,
          sections_requested,
          generated_at,
          message: resp.message ?? null,
        };
      }

      throw new Error('An error occurred. Please try again later.');
    } catch (error) {
      throw new Error(extractErrorMessage(error));
    }
  }

  /**
   * Get available sections
   * @returns {array}
   */
  getAvailableSections() {
    // Provide only backend-supported sections; keep an 'all' UI option that maps to no param
    return AVAILABLE_SECTIONS;
  }
}

// Export singleton instance
export default new ProjectInsightsService();

// Also export the class for additional usage
export { ProjectInsightsService };

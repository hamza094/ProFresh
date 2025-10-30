/**
 * ProjectInsights Mixin
 * 
 * Provides common functionality for components that need to work with project insights
 */

import ProjectInsightsService from '../services/ProjectInsightsService.js'
import { canonicalSectionsKey } from '../utils/insightsSections.js'

const TTL = 5 * 60 * 1000 // 5 minutes

export default {
  data() {
    return {
      projectInsightsLoading: false,
      projectInsightsError: null,
      projectInsightsCache: new Map(),
      projectInsightsPending: new Map()
    }
  },

  methods: {
    resolveProjectSlug(project) {
      if (project) return typeof project === 'string' ? project : (project.slug || project.id)
      return this.projectSlug || (this.project && (this.project.slug || this.project.id)) || null
    },

    async loadProjectInsights(project, sections = null, useCache = true) {
      const slug = this.resolveProjectSlug(project)
      if (!slug) throw (this.projectInsightsError = 'No project specified', new Error('No project specified'))

      // canonical key (shared helper)
      const key = `${slug}:${canonicalSectionsKey(sections)}`
      const now = Date.now()
      const cached = useCache && this.projectInsightsCache.get(key)
      if (cached && (now - cached.ts) < TTL) return cached.data

      if (this.projectInsightsPending.has(key)) return this.projectInsightsPending.get(key)

      this.projectInsightsLoading = true
      this.projectInsightsError = null

      const p = (async () => {
        try {
          const r = await ProjectInsightsService.getInsights(slug, sections)
          this.projectInsightsCache.set(key, { data: r, ts: Date.now() })
          return r
        } catch (e) {
          this.projectInsightsError = (e && e.message) ? e.message : String(e)
          throw e
        } finally {
          this.projectInsightsPending.delete(key)
          this.projectInsightsLoading = false
        }
      })()

      this.projectInsightsPending.set(key, p)
      return p
    },

    loadCurrentProjectInsights(sections = null, useCache = true) {
      return this.loadProjectInsights(undefined, sections, useCache)
    },

    clearProjectInsightsCache(projectSlug = null) {
      if (!projectSlug) { this.projectInsightsCache.clear(); this.projectInsightsPending.clear(); return }
      const prefix = String(projectSlug) + ':'
      this.projectInsightsCache.forEach(function(_, k, m) { if (String(k).indexOf(prefix) === 0) m.delete(k) })
      this.projectInsightsPending.forEach(function(_, k, m) { if (String(k).indexOf(prefix) === 0) m.delete(k) })
    },

    clearCurrentProjectInsightsCache() { const s = this.resolveProjectSlug(); if (s) this.clearProjectInsightsCache(s) }
  },

  beforeDestroy() {
    this.projectInsightsCache.clear(); this.projectInsightsPending.clear()
  }
}

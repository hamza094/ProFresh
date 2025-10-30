// Helpers for normalizing insight section keys
const VALID_SECTIONS = ['health', 'task-health', 'collaboration', 'risk', 'stage']

function normalizeSectionsForRequest(sections) {
  if (!Array.isArray(sections)) return []
  return sections
    .map(s => String(s).trim().toLowerCase())
    .filter(Boolean)
    .filter(s => VALID_SECTIONS.includes(s))
}

function canonicalSectionsKey(sections) {
  if (!Array.isArray(sections) || !sections.length) return 'all'
  const parts = Array.from(new Set(
    sections.map(s => String(s).trim().toLowerCase()).filter(Boolean).filter(s => s !== 'all')
  )).sort()
  return parts.length ? parts.join(',') : 'all'
}

export { VALID_SECTIONS, normalizeSectionsForRequest, canonicalSectionsKey }

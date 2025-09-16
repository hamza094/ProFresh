<template>
  <div class="insight-card" :class="[ 'insight-card_'+typeKey, compact ? 'insight-card_compact' : '' ]">
    <div class="insight-card_header">
      <div class="insight-header-content">
        <i v-if="iconClass" :class="['insight-icon', iconClass, 'icon-'+typeKey]"></i>
        <h5 class="insight-title">{{ insight.title }}</h5>
      </div>
      <div v-if="!compact" class="insight-badge" :class="'badge-'+typeKey">{{ typeLabel }}</div>
    </div>
    <div class="insight-card_body">
      <div v-if="compact" class="insight-compact-row">
        <span class="compact-value">{{ displayNumber }}</span>
        <span class="compact-label">{{ compactLabel }}</span>
      </div>
      <div v-else class="insight-value-container">
        <div class="insight-value">
          <span class="value-number">{{ displayNumber }}</span>
          <span v-if="valueUnit" class="value-unit">{{ valueUnit }}</span>
        </div>
      </div>
      <p v-if="insight.message" class="insight-message">{{ insight.message }}</p>
      <div v-if="hasMeta" class="insight-meta">
        <div v-if="insight.data && insight.data.stage" class="meta-item"><i class="fas fa-layer-group"></i><span>{{ insight.data.stage }}</span></div>
        <div v-if="insight.data && insight.data.score !== undefined" class="meta-item"><i class="fas fa-star"></i><span>Score: {{ insight.data.score }}</span></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InsightCard',
  props: { insight: { type: Object, required: true }, compact: { type: Boolean, default: false } },
  computed: {
    typeKey() { return (this.insight && this.insight.type) ? this.insight.type : 'info' },
    typeLabel() {
      var map = { success: 'Good', warning: 'Warning', critical: 'Critical', info: 'Info', health: 'Health' };
      return map[this.typeKey] || this.typeKey;
    },
    isPercentage() {
      if (!this.insight || !this.insight.data) return false;
      if (this.insight.data.unit === '%') return true;
      var t = (this.insight.title || '').toLowerCase();
      return ['health','completion','progress','percent'].some(function(k){ return t.indexOf(k) !== -1 });
    },
    numericValue() {
      if (!this.insight || !this.insight.data) return null;
      var d = this.insight.data;
      var v = d.value !== undefined ? d.value : (d.count !== undefined ? d.count : null);
      if (v === null) return null;
      if (this.isPercentage && typeof v === 'number' && v >= 0 && v <= 1) v = v * 100;
      return v;
    },
    displayNumber() {
      if (this.numericValue === null) return '-';
      if (typeof this.numericValue === 'number') {
        return this.isPercentage ? Math.round(this.numericValue) : Math.round(this.numericValue * 100) / 100;
      }
      return this.numericValue;
    },
    valueUnit() {
      if (this.isPercentage) return '%';
      if (this.insight && this.insight.data && this.insight.data.unit) return this.insight.data.unit;
      return '';
    },
    compactLabel() { return this.valueUnit || this.typeLabel; },
    iconClass() {
      if (!this.insight) return '';
      var t = (this.insight.title || '').toLowerCase();
      if (t.indexOf('health') !== -1) return 'fas fa-heartbeat';
      if (t.indexOf('overdue') !== -1) return 'fas fa-exclamation-triangle';
      if (t.indexOf('risk') !== -1) return 'fas fa-warning';
      if (t.indexOf('engagement') !== -1 || t.indexOf('team') !== -1) return 'fas fa-users';
      if (t.indexOf('progress') !== -1 || t.indexOf('completion') !== -1) return 'fas fa-chart-line';
      return '';
    },
    hasMeta() { return !!(this.insight && this.insight.data && (this.insight.data.stage || this.insight.data.score !== undefined)); }
  }
}
</script>

<style scoped>
.insight-card { background:#fff; border:1px solid #E5E5EE; border-radius:8px; overflow:hidden; }
.insight-card_header { display:flex; justify-content:space-between; align-items:flex-start; padding:8px 12px; }
.insight-header-content { display:flex; align-items:center; gap:8px; }
.insight-title { margin:0; font-size:0.95rem; font-weight:600; color:#2F2536; }
.insight-icon { font-size:14px; width:18px; text-align:center; }

.insight-card_success { border-left:4px solid #27AE60; }
.insight-card_warning { border-left:4px solid #F39C12; }
.insight-card_critical { border-left:4px solid #E74C3C; }
.insight-card_info { border-left:4px solid #17A2B8; }
.insight-card_health { border-left:4px solid #0B8457; }

.icon-success, .badge-success { color:#27AE60; }
.icon-warning, .badge-warning { color:#F39C12; }
.icon-critical, .badge-critical { color:#E74C3C; }
.icon-info, .badge-info { color:#17A2B8; }
.icon-health, .badge-health { color:#0B8457; }

.insight-badge { font-size:0.65rem; padding:3px 8px; border-radius:999px; text-transform:uppercase; font-weight:600; letter-spacing:0.5px; background:#F5F6F7; }
.badge-success { background:#D4F4DD; }
.badge-warning { background:#FFF3CD; }
.badge-critical { background:#F8D7DA; }
.badge-info { background:#D1ECF1; }
.badge-health { background:#D6F5EC; }

.insight-card_body { padding:6px 12px 12px 12px; }
.insight-compact-row { display:flex; align-items:baseline; gap:6px; }
.compact-value { font-weight:700; font-size:1rem; color:#1D4967; }
.compact-label { font-size:0.65rem; color:#555; text-transform:uppercase; letter-spacing:0.5px; font-weight:600; }

.insight-value-container { margin-bottom:6px; }
.value-number { font-size:1.4rem; font-weight:700; color:#1D4967; }
.value-unit { margin-left:4px; font-size:0.8rem; color:#555; font-weight:600; }

.insight-message { margin:6px 0 0 0; color:#555; font-size:0.78rem; line-height:1.25; }
.insight-meta { display:flex; gap:10px; margin-top:8px; }
.meta-item { display:flex; gap:4px; align-items:center; color:#888; font-size:0.7rem; }

.insight-card_compact { border-radius:6px; }
.insight-card_compact .insight-card_header { padding:6px 8px; }
.insight-card_compact .insight-card_body { padding:4px 8px 8px 8px; }
.insight-card_compact .compact-value { font-size:0.95rem; }
.insight-card_compact .compact-label { font-size:0.6rem; }

.insight-card_health .value-number, .insight-card_health .compact-value { color:#0B8457; }
</style>

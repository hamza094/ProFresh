<template>
  <div class="insight-filters">
    <div class="filter-buttons">
      <button
        v-for="section in sections"
        :key="section.key"
        @click="toggleSection(section.key)"
        :class="[
          'filter-btn',
          { 'filter-btn_active': isActive(section.key) },
          { 'filter-btn_all': section.key === 'all' }
        ]"
        :title="section.label"
      >
        <i :class="section.icon"></i>
        <span class="filter-label">{{ section.label }}</span>
      </button>
    </div>
    
    <!-- Quick Actions -->
    <div class="filter-actions">
      <button 
        @click="selectAll" 
        class="action-btn"
        :class="{ 'action-btn_active': activeSections.includes('all') }"
      >
        <i class="fas fa-th"></i>
        All
      </button>
      <button @click="clearAll" class="action-btn">
        <i class="fas fa-times"></i>
        Clear
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'InsightFilters',
  props: {
    sections: {
      type: Array,
      required: true
    },
    activeSections: {
      type: Array,
      default: () => ['all']
    }
  },
  data() {
    return {
      localActiveSections: [...this.activeSections]
    }
  },
  watch: {
    activeSections: {
      handler(newSections) {
        this.localActiveSections = [...newSections]
      },
      deep: true
    }
  },
  methods: {
    toggleSection(sectionKey) {
      if (sectionKey === 'all') {
        this.selectAll()
        return
      }
      
      // Remove 'all' if selecting specific sections
      if (this.localActiveSections.includes('all')) {
        this.localActiveSections = [sectionKey]
      } else {
        const index = this.localActiveSections.indexOf(sectionKey)
        if (index > -1) {
          this.localActiveSections.splice(index, 1)
        } else {
          this.localActiveSections.push(sectionKey)
        }
        
        // If no sections selected, default to 'all'
        if (this.localActiveSections.length === 0) {
          this.localActiveSections = ['all']
        }
      }
      
      this.emitChange()
    },
    
    selectAll() {
      this.localActiveSections = ['all']
      this.emitChange()
    },
    
    clearAll() {
      this.localActiveSections = []
      this.emitChange()
    },
    
    isActive(sectionKey) {
      if (sectionKey === 'all') {
        return this.localActiveSections.includes('all')
      }
      return this.localActiveSections.includes(sectionKey) && !this.localActiveSections.includes('all')
    },
    
    emitChange() {
      this.$emit('filter-change', [...this.localActiveSections])
    }
  }
}
</script>

<style scoped>
.insight-filters {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.filter-buttons {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.filter-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.5rem 0.75rem;
  background: #F8F9FA;
  border: 1px solid #E5E5EE;
  border-radius: 1.5rem;
  font-size: 0.85rem;
  font-weight: 500;
  color: #666666;
  cursor: pointer;
  transition: all 0.2s ease;
  outline: none;
}

.filter-btn:hover {
  background: #E5F2FD;
  border-color: #1D4967;
  color: #1D4967;
}

.filter-btn_active {
  background: #1D4967;
  border-color: #1D4967;
  color: white;
}

.filter-btn_all.filter-btn_active {
  background: #27AE60;
  border-color: #27AE60;
}

.filter-btn i {
  font-size: 0.9rem;
}

.filter-label {
  white-space: nowrap;
}

.filter-actions {
  display: flex;
  gap: 0.25rem;
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  padding: 0.4rem 0.6rem;
  background: transparent;
  border: 1px solid #E5E5EE;
  border-radius: 0.25rem;
  font-size: 0.8rem;
  color: #999999;
  cursor: pointer;
  transition: all 0.2s ease;
  outline: none;
}

.action-btn:hover {
  background: #F8F9FA;
  color: #666666;
}

.action-btn_active {
  background: #27AE60;
  border-color: #27AE60;
  color: white;
}

.action-btn i {
  font-size: 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .insight-filters {
    flex-direction: column;
    align-items: stretch;
  }
  
  .filter-buttons {
    justify-content: center;
  }
  
  .filter-actions {
    justify-content: center;
  }
  
  .filter-label {
    display: none;
  }
  
  .filter-btn {
    padding: 0.5rem;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    justify-content: center;
  }
}
</style>

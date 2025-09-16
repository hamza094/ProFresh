<template>
  <div>

    <div class="img-avatar">
      <div class="img-avatar_name">{{ projectInitial }}</div>
    </div>

  <div>
  <div class="score-dropdown" ref="dropdown" :id="'score-dropdown-' + _uid">

        <!-- trigger -->
        <span
          role="button"
          tabindex="0"
          :aria-expanded="String(isPop)"
          :aria-controls="'score-dropdown-' + _uid"
          @click.stop="isPop = !isPop"
          class="score-point"
          :class="'score-point_'+status"
          @keydown.enter.prevent="isPop = !isPop"
          @keydown.space.prevent="isPop = !isPop"
        >
          {{ score }}
        </span>

        <!-- Enhanced menu with insights -->
        <div class="score-dropdown_item" v-show="isPop">
          <div class="score">

            <!-- Project Info Header -->
            <div class="score-content">
              <p class="score-content_para">
                <i class="far fa-clock"></i>
                The project started {{ start }}. Currently in its
                <b v-text="stagename()"></b> stage
              </p>
            </div>

            <!-- Enhanced with Project Insights -->
            <div class="insights-section">
              <div class="insights-header d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom-0">
                <h5 class="mb-0 d-flex align-items-center">
                  <i class="fas fa-chart-line me-2"></i>
                  Project Insights
                </h5>

                <button
                  @click.stop="toggleInsightsView($event)"
                  class="insights-toggle d-inline-flex align-items-center justify-content-center"
                  :class="{ 'active': showDetailedInsights }"
                >
                  <i :class="showDetailedInsights ? 'fas fa-compress' : 'fas fa-expand'" />
                </button>
              </div>

              <ProjectInsights
                v-if="project && showDetailedInsights"
                :project="project"
                :compact="true"
                :initial-sections="['health', 'overdue', 'risk']"
              />

              <!-- Quick action: open full insights modal -->
              <div v-if="project && showDetailedInsights" class="insights-actions mt-3 pt-2 text-end">
                <button class="btn-full-insights d-inline-flex align-items-center" @click.stop="openInsightsModal($event)">
                  <i class="fas fa-chart-bar" />
                  View Complete Insights
                </button>
              </div>
            </div>

            <!-- Legacy Score Info (kept for compatibility) -->
            <div class="score-content_point" v-if="!showDetailedInsights">
              <p class="score-content_point-para"><b>Score Factors</b></p>

              <div class="row">
                <div class="col-md-4">
                  <p class="score-content_point-cold">
                    <span>
                      <span :class="'score-content_point-'+status+'_point'">{{ score }}</span>
                      <br />
                      <span :class="'score-content_point-'+status+'_status'">{{ status }}</span>
                    </span>
                  </p>
                </div>

                <div class="col-md-8">
                  <div>
                    <p class="project-score">
                      <span><i class="fas fa-arrow-up" /></span>
                      New tasks boost project score
                    </p>

                    <p class="project-score">
                      <span><i class="fas fa-arrow-up" /></span>
                      Project notes improve rating
                    </p>

                    <p class="project-score">
                      <span><i class="fas fa-arrow-up" /></span>
                      Team collaboration increases score
                    </p>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

    <!-- Project Insights Modal -->
    <ProjectInsightsModal :project="project" />

  </div>
</template>

<script>
import ProjectInsights from './Insights/ProjectInsights.vue';
import ProjectInsightsModal from './Insights/ProjectInsightsModal.vue';

export default {
  components: {
    ProjectInsights,
    ProjectInsightsModal,
  },

  props: {
    projectName: { type: String, default: '' },
    start: { type: String, default: '' },
    stage: { type: [String, Number], default: null },
    completed: { type: Boolean, default: false },
    status: { type: String, default: '' },
    score: { type: [Number, String], default: 0 },
    project: { type: Object, default: null },
  },

  data() {
    return {
      isPop: false,
      clickOutsideHandler: null,
      showDetailedInsights: false,
    };
  },

  watch: {
    isPop: {
      handler(isOpen) {
        isOpen ? this.addClickOutsideListener() : this.removeClickOutsideListener();
      },
    },
  },

  beforeDestroy() {
    this.removeClickOutsideListener();
  },

  methods: {
    stagename() {
      if (typeof this.currentStage !== 'function') return '';
      return this.currentStage(this.stage, this.completed);
    },

    addClickOutsideListener() {
      if (this.clickOutsideHandler) return;

      this.$nextTick(() => {
        this.clickOutsideHandler = (event) => {
          if (this.$refs.dropdown && !this.$refs.dropdown.contains(event.target)) {
            this.isPop = false;
          }
        };

        document.addEventListener('click', this.clickOutsideHandler);
      });
    },

    removeClickOutsideListener() {
      if (!this.clickOutsideHandler) return;

      document.removeEventListener('click', this.clickOutsideHandler);
      this.clickOutsideHandler = null;
    },

    openInsightsModal(event) {
      event && event.stopPropagation();

      if (!this.project) {
        console.warn('No project available for insights modal');
        return;
      }

      this.isPop = false;
      this.$modal.show('project-insights-modal', { project: this.project });
    },

    toggleInsightsView(event) {
      event && event.stopPropagation();
      this.showDetailedInsights = !this.showDetailedInsights;
    },
  },

  computed: {
    projectInitial() {
      return (this.projectName || '').substring(0, 1).toUpperCase();
    },
  },
};
</script>

<template>
  <div class="m-3">
    <div class="calendar-wrapper relative">
      <vc-calendar
        is-expanded
        v-model="currentMonth"
        :attributes="attributes"
        @update:from-page="onPageChange"
      >
        <!-- Vue 3 slot syntax -->
        <template #day-popover="{ dayTitle, attributes }">
          <div class="p-2 user-popover-container">
            <div class="text-muted small mb-1">{{ dayTitle }}</div>

            <ul class="user-popover-list">
              <li
                v-for="attr in attributes"
                :key="attr.key || attr.customData?.id || Math.random()"
                class="d-flex align-items-center mb-1"
              >
                <!-- Colored dot -->
                <span
                  class="user-activity-dot mr-2"
                  :style="{ backgroundColor: attr.customData?.color }"
                ></span>

                <!-- Project link -->
                <router-link
                  v-if="attr.customData?.project?.slug"
                  :to="`/projects/${attr.customData.project.slug}`"
                  class="user-activity-link"
                >
                  {{ attr.customData?.description || 'Activity' }}
                </router-link>

                <!-- Created at -->
                <div class="user-popover-date small pl-2 text-muted">
                  {{ formatTime(attr.customData?.created_at) }}
                </div>
              </li>
            </ul>
          </div>
        </template>
      </vc-calendar>

      <!-- Spinner Overlay -->
      <div v-if="isLoading" class="calendar-loader" role="status" aria-live="polite">
        <div class="loader-backdrop"></div>
        <div class="loader-content">
          <i class="fas fa-spinner fa-pulse loader-icon" aria-hidden="true"></i>
          <div class="loader-text">Loading activities...</div>
        </div>
      </div>

      <!-- Error state -->
      <div v-if="errorMessage" class="calendar-error alert alert-danger" role="alert">
        {{ errorMessage }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import VCalendar from 'v-calendar'
import moment from 'moment'
import axios from 'axios'

// Register Calendar
const components = { 'vc-calendar': VCalendar.Calendar }

const activities = ref([])
const currentMonth = ref(moment().toDate())
const cancelTokenSource = ref(null)
const isLoading = ref(false)
const errorMessage = ref(null)

// Computed attributes for calendar
const attributes = computed(() =>
  activities.value
    .map((activity) => ({
      dates: activity.created_at ? moment(activity.created_at).toDate() : null,
      bar: { color: activity.color },
      popover: true,
      customData: activity,
    }))
    .filter((attr) => attr.dates !== null)
)

// Helpers
function formatTime(date) {
  return date ? moment(date).format('YYYY-MM-DD HH:mm') : ''
}

function onPageChange(page) {
  let refDate
  if (page?.month && page?.year) {
    refDate = moment(`${page.year}-${page.month}-01`)
  } else if (Array.isArray(page) && page.length) {
    refDate = moment(page[0])
  } else {
    refDate = moment(page)
  }

  if (!refDate || !refDate.isValid()) return

  const start_date = refDate.clone().startOf('month').format('YYYY-MM-DD')
  const end_date = refDate.clone().endOf('month').format('YYYY-MM-DD')

  calendarData({ start_date, end_date })
}

function calendarData({ start_date, end_date } = {}) {
  if (cancelTokenSource.value) {
    cancelTokenSource.value.cancel('New request triggered, cancelling old one.')
  }
  cancelTokenSource.value = axios.CancelToken.source()
  isLoading.value = true

  if (!start_date || !end_date) {
    const refDate = moment(currentMonth.value)
    start_date = refDate.clone().startOf('month').format('YYYY-MM-DD')
    end_date = refDate.clone().endOf('month').format('YYYY-MM-DD')
  }

  axios
    .get('/api/v1/user/activities', {
      params: { start_date, end_date },
      cancelToken: cancelTokenSource.value.token,
    })
    .then((response) => {
      activities.value =
        response.data?.data ?? response.data ?? []
      errorMessage.value = null
    })
    .catch((error) => {
      if (!axios.isCancel(error)) {
        console.error('Failed to load activities', error)
        activities.value = []
        errorMessage.value = 'Unable to load activities. Please try again later.'
      }
    })
    .finally(() => {
      isLoading.value = false
    })
}

onMounted(() => {
  calendarData()
})

onBeforeUnmount(() => {
  if (cancelTokenSource.value) {
    try {
      cancelTokenSource.value.cancel('Component unmounted')
    } catch (e) {}
  }
})
</script>

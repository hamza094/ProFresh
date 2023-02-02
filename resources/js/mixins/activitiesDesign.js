export default {
  data() {
    return {
      activityData: {
        "Task": {
          icon: 'fas fa-tasks',
          color: 'activity-icon_primary'
        },
        "Project invitation": {
          icon: 'fas fa-user',
          color: 'activity-icon_green'
        },
        "Project member": {
          icon: 'fas fa-user',
          color: 'activity-icon_green'
        }
      }
    }
  },
  methods: {
    getIcon(description) {
      const prefix = Object.keys(this.activityData).find(
        prefix => description.startsWith(prefix)) || 'default';

      return (this.activityData[prefix] && 
      this.activityData[prefix].icon) || 'fab fa-pagelines';
    },

     getColor(description) {
      const prefix = Object.keys(this.activityData).find(
        prefix => description.startsWith(prefix)) || 'default';

      return (this.activityData[prefix] &&
       this.activityData[prefix].color) || 'activity-icon_purple';
    },
  }
}

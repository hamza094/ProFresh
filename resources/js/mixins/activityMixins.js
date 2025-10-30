export default {
  data() {
    return {
      activityTypes: [
        { status: 'all', label: 'All Activities', icon: 'fa-layer-group', color: 'secondary', query: '' },
        { status: 'my', label: 'My Activities', icon: 'fa-user', color: 'purple', query: '?mine=1' },
        { status: 'project', label: 'Project Activities', icon: 'far fa-star', color: 'green', query: '?specifics=1' },
        { status: 'task', label: 'Task Activities', icon: 'fa-tasks', color: 'primary', query: '?tasks=1' },
        { status: 'member', label: 'Member Activities', icon: 'fa-users', color: 'danger', query: '?members=1' },
      ],
      activityData: {
        Task: {
          icon: 'fas fa-tasks',
          color: 'activity-icon_primary',
        },
        'Project invitation': {
          icon: 'fas fa-user',
          color: 'activity-icon_green',
        },
        'Project member': {
          icon: 'fas fa-user',
          color: 'activity-icon_green',
        },
      },
    };
  },
  methods: {
    getIcon(description) {
      const prefix = Object.keys(this.activityData).find((prefix) => description.startsWith(prefix)) || 'default';

      return (this.activityData[prefix] && this.activityData[prefix].icon) || 'fab fa-pagelines';
    },

    getColor(description) {
      const prefix = Object.keys(this.activityData).find((prefix) => description.startsWith(prefix)) || 'default';

      return (this.activityData[prefix] && this.activityData[prefix].color) || 'activity-icon_purple';
    },
  },
};

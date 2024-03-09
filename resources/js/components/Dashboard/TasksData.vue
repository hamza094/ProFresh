<template>
  <div class="col-md-7">
                <div class="card" style="height: 28rem">
     <div class="card-header d-flex justify-content-between">
    <span class="float-left">Your Tasks  
      <b><span v-for="filter in filters">
        > {{filter}}
      </span> </b>
    </span>
    <span class="float-right d-flex">
      <div class="form-check mr-3">
        <input class="form-check-input" type="checkbox" value="" id="assignedTasks" v-model="form.assigned">
        <label class="form-check-label" for="assignedTasks">
          Assigned Tasks
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="createdTasks" v-model="form.created">
        <label class="form-check-label" for="createdTasks">
          Created Tasks
        </label>
      </div>
    </span>
  </div>
        <div class="card-body card-body-scrollable card-body-scrollable-shadow">
            <div class="divide-y"> 

                  <!-- Filter options -->
                  <div class="row">
                    <ul class="nav nav-pills">
                        <li class="nav-pills_listitems btn btn-link" @click.prevent="allTasks">all tasks</li>
                        <li class="nav-pills_listitems btn btn-link" @click.prevent="overdueTasks">overdue tasks</li>
                        <li class="nav-pills_listitems btn btn-link" @click.prevent="remainingTasks">remaining tasks</li>
                        <li class="nav-pills_listitems btn btn-link" @click.prevent="completedTasks">completed tasks</li>
                    </ul>

                      <!-- Task list -->
                      <div class="col">
                            <div class="" v-for="task in userTasks" :key="task.id">
                            <div class="horizontal-line"></div>

                        <!-- Task details -->
                        <div>
                    <i><p>
                        <!-- Task icon based on state -->
                          <i :class="task.state === 'created' ? 'created_icon fas fa-user-edit' : 'assigned_icon fas fa-user'"></i>
                              {{task.title}}

                          <!-- Task status badge -->
                          <span :style="'background-color: ' + task.status.color" class="badge ml-1">{{task.status.label}} 
                          </span>

                          <span v-if="filters.includes('Filter by Overdue')" class="badge badge-danger">
                              Overdue
                          </span>

                          <span v-if="filters.includes('Filter by Remaining')" class="badge badge-info">Remaining</span>
                        </p>
                      <p>
                          <!-- Due date, created at and project details -->
                          <span v-if="task.due_at"><i class="fas fa-stopwatch"></i>19 feb 12</span>

                        <span class="ml-3">
                        <i class="fas fa-project-diagram"></i>
                        <router-link :to="'/projects/' + task.project.slug" class="tasks-link" :class="{'trash-link': task.project.state === 'trashed'}">{{task.project.name}}
                        </router-link>
                      </span>

                      <span class="float-right"><i class="far fa-clock"></i> {{task.created_at}}</span>
                    </p>

                    <!-- Assignee details -->
                   <span v-if="task.assignee" v-for="user in task.assignee">
                      <i class="far fa-user"></i>
                        <router-link class="mr-2" :to="'/user/' + user.id + '/profile'"
                          target="_blank">{{user.name}}</router-link>
                        </span>
                  </i>
                      </div>
                      </div>
                    </div>
                    </div>
                
            </div>
        </div>
    </div>
            </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        assigned: true,
        created: true,
      },
      userTasks: [],
      filters:[],
    };
  },
  methods: {
    loadTasksData(params) {
      if (this.form.assigned) params.task_assigned = true;
      if (this.form.created) params.user_created = true;

      axios.get('/api/v1/tasksdata', { params })
        .then(response => {
          this.userTasks = response.data.tasks;
          this.filters = response.data.applied_filters;
        })
        .catch(error => {
          console.log(error);
        });
    },
     filterTasks(params) {
      this.loadTasksData(params);
    },
    overdueTasks() {
      this.filterTasks({ overdue: true });
    },
    remainingTasks() {
      this.filterTasks({ remaining: true });
    },
    completedTasks() {
      this.filterTasks({ completed: true });
    },
    allTasks() {
      this.filterTasks({});
    },
  },
  computed: {},
  mounted() {
    this.allTasks();
  },
};
</script>
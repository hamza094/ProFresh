<template>
	<div>
  <div class="page-top mb-4">Welcome To Tasks Panel</div>
   <div class="container">
     		<div class="row">
          <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Tasks > {{this. appliedFilter}}</h3>
                  </div>

                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                              Search:
    <div class="ms-2 d-inline-block">
    <input type="text" class="form-control form-control-sm" placeholder="By Project" name="search" autocomplete="off" v-model="searchTerm" @keydown="searchTasks()">
                        </div>

    <div class="ms-auto text-secondary">
     <span>
        <button class="btn btn-sm btn-primary" @click="getResults(1,'all')">All Tasks</button>
      <button class="btn btn-sm btn-success" @click="getResults(1,'active')">Active Tasks</button>
      <button class="btn btn-sm btn-warning" @click="getResults(1,'trashed')">Trashed Tasks</button>
     </span>
    </div>

    <div class="ms-auto text-secondary">
      <button class="btn btn-sm btn-danger" @click.pervent="bulkDelete()">Bulk Delete</button>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                    <div v-if="message" class=" mt-3 text-center"><h4>{{message}}</h4></div>
                    <table v-else class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all tasks"
                          v-model="selectAll"
                          @change="selectAllTasks"></th>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Desc</th>
                          <th>Status</th>
                          <th>Owner</th>
                          <th>Belongs To</th>
                          <th>State</th>
                          <th>Members</th>
                          <th>Due_At</th>
                          <th>Created_At</th>
                          <th>Updated_At</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(task,index) in tasks.data" :key="task.id">
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select task"
                          v-model="selectedTasks"
                          :value="task.id"></td>
                          <td>{{task.id}}</td>
                          <td>{{task.title}}</td>
                          <td>{{task.description}}</td>
                          <td><span class="task-option_labels-component" :style="{backgroundColor: task.status.color}">{{task.status.label}}</span>
                          </td>
                          <td>
                          <router-link :to="'/user/'+task.owner.id+'/profile'" class="admin-panel-link">
                        <div>{{task.owner.name}}</div>
                        </router-link>
                        </td>
                          <td>
                           <router-link :to="'/projects/'+task.project.slug" class="admin-panel-link">
                        <div>{{task.project.name}}</div>
                        </router-link>
                        </td>
                        <td><span v-if="task.state == 'active'" class="bg badge bg-success me-1">{{task.state}}</span>
                            <span v-else class="bg badge bg-warning me-1">{{task.state}}</span></td>
                          <td style="max-height: 100px; overflow-y: auto;">
    <div v-for="member in task.members">{{ member.name }}</div>
</td>
                          <td>
                          <span v-if="task.due_at">{{task.due_at}}
                          </span>
                          <span v-else>Not Defined</span>
                        </td>
                        <td>{{task.created_at}}</td>
                          <td>{{task.updated_at}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex">
     <p class="float-left">Showing <span>{{from}}</span> to {{to}}<span></span> of <span></span>{{total}} entries</p>
                        <pagination :data="this.tasks" @pagination-change-page="paginate($event, filter)"></pagination>
                  </div>
                </div>
              </div>
     		</div>

        </div>
 
	</div>
</template>
<script>
  import { debounce } from 'lodash';

export default{
    data(){
    return{
	   tasks:[],
       from:0,
       to:0,
       total:0,
       selectedTasks: [],
       selectAll: false,
       message:'',
       appliedFilter:'',
       filter:'',
       searchTerm:'',

    };
    }, 
    watch:{
   
    },
  methods:{
        getResults(page = 1,filter = 'all') {
      const queryParameters = {
        page: page,
        filter:filter,
        search: this.searchTerm,
      };

      if(filter === 'all'){
        this.appliedFilter='All Tasks';
        this.filter='all';
      }
      if(filter === 'trashed'){
        this.appliedFilter='Trashed Tasks';
        this.filter='trashed';
      }
      if(filter === 'active'){
        this.appliedFilter='Active Tasks';
        this.filter='active';
      }
      axios.get('/api/v1/admin/tasks', {
        params: queryParameters,
      })
      .then(response => {
      this.tasks = response.data || '';
      this.from = this.tasks.meta.from || '';
      this.to = this.tasks.meta.to || '';
      this.total = this.tasks.meta.total || '';
      this.message = response.data.data ? '' : response.data.message;
        })
        .catch(error => {
        });
    },
     searchTasks:debounce(function () { 
      this.getResults();
    },1000),

    paginate(page, filter) {
  this.getResults(page, filter);
},
        bulkDelete(){
           if (this.selectedTasks.length === 0) {
        return;
      }
      this.sweetAlert('Yes, Delete Selected ' + this.selectedTasks.length + ' Tasks!')
        .then((result) => {
          if (result.value) {
            axios.delete('/api/v1/admin/tasks/bulk-delete', {
              data: { task_ids: this.selectedTasks },
            })
              .then((response) => {
                this.$vToastify.success(response.data.message);
                this.getResults();
              })
              .catch((error) => {
                swal.fire('Failed!', 'There was something wrong.', 'warning');
              });
          }
            this.selectedTasks = [];
            this.selectAll=false;
        });

        }, 
     selectAllTasks() {
      if (this.selectAll) {
      this.selectedTasks = this.tasks.data.map((task) => task.id);
      } else {
        this.selectedTasks = [];
      }
    },    

    },
    mounted(){
      this.getResults();
    }
}
</script>
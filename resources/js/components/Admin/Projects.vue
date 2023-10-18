<template>
	<div>
  <div class="page-top mb-4">Welcome To Your Project Panel</div>
   <div class="container">
     		<div class="row">
          <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Projects</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                    
                        <span class="dropdown">
                              <button class="btn btn-primary dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Filters</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                      <div class="ms-auto text-secondary">
                        <button class="btn btn-sm btn-danger">Bulk Delete</button>
                      </div>

                      <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                          <th class="w-1">No.
                            <i v-if="currentSort === 'asc'" class="fas fa-angle-up angle-pointer" @click="toggleSort('asc')"></i>

                            <i v-if="currentSort === 'desc'" class="fas fa-angle-down angle-pointer" @click="toggleSort('desc')"></i>
                          </th>
                          <th>Name</th>
                          <th>Desc</th>
                          <th>Score</th>
                          <th>Stage</th>
                          <th>State</th>
                          <th>Owner</th>
                          <th>Created_at</th>
                          <th>Tasks_count</th>
                          <th>Members_count</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(project,index) in projects.data" :key="project.id">
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td>{{project.id}}</td>
                          <td>
                            <router-link :to="'/projects/'+project.slug" class="admin-panel-link">
                            <span>{{project.name}}</span>
                        </router-link>
                        </td>
                          <td>{{project.about}}</td>
                          <td>
                            {{project.score}} / 
                            <span v-if="project.status == 'cold'" class="badge bg-info">{{project.status}}</span>
                            <span v-else class="badge bg-danger">{{project.status}}</span>
                             
                          </td>
                          <td>
                            {{project.stage.name}}
                          </td>
                          <td><span v-if="project.state == 'active'" class="bg badge bg-success me-1">{{project.state}}</span>
                            <span v-else class="bg badge bg-warning me-1">{{project.state}}</span>
                          </td>
                          <td>
                        <router-link :to="'/user/'+project.owner.id+'/profile'" class="admin-panel-link">
                        <span>{{project.owner.name}}</span>
                        </router-link>
                          </td>
                          <td>
                            <span class="badge bg-success me-1"></span> {{project.created_at}}
                          </td>
                          <td>{{project.tasks_count}}</td>
                          <td>{{project.members_count}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex">
                    <p class="float-left">Showing <span>{{from}}</span> to {{to}}<span></span> of <span></span>{{total}} entries</p>
                        <pagination :data="this.projects" @pagination-change-page="getResults"></pagination>
                
                  </div>
                </div>
              </div>
     		</div>

            <div class="card mt-5">
                  <div class="card-header">
                    <h3 class="card-title">Chats</h3>
                  </div>
                </div>
        </div>
 
	</div>
</template>
<script>

export default{
    data(){
    return{
	   projects:[],
       totalProjects:0,
       currentSort: 'desc',
       from:0,
       to:0,
       total:0,
    };
    },
    methods:{			
        getResults(page=1){
        axios.get(`/api/v1/admin/projects?page=${page}&sort=${this.currentSort}`)
        .then(response => {
        this.from=response.data.projects.meta.from;
        this.to=response.data.projects.meta.to;
        this.total=response.data.projects.meta.total;
        this.projects=response.data.projects;
        this.totalProjects=response.data.projectsCount;
        })
        .catch(error => {
          //console.log(error.response.data.errors);
        })
        },
      toggleSort(order) {
      // Toggle sorting order when clicking the angle icons
      this.currentSort = this.currentSort === order ? (order === 'asc' ? 'desc' : 'asc') : order;
      this.getResults();
    },
    },
    mounted(){
        this.getResults();
    }
}
</script>
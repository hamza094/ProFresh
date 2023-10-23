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
                        <div class="filter-dropdown">
                              <span class="filter" @click="isPop = !isPop">Filters <i class="fas fa-filter"></i></span>
                             <div class="filter-dropdown_item" v-show=isPop>
                                 <div class="container">
                                    <div class="filter-content">
                                        <div class="row">
                                            <h4>Filter By</h4>
                                            <div class="col-md-4">
  <input class="form-check-input" type="radio"
   v-model="form.projects" id="RadioProjects" value="active"   @click="toggleRadio('active')"> 
  Active Projects                                            
    </div>
    <div class="col-md-4">
  <input class="form-check-input" type="radio" v-model="form.projects" id="RadioProjects" value="trashed" @click="toggleRadio('trashed')"> 
  Trashed Projects  
    </div>
    <div class="col-md-4">
    <div class="form-check">
  <input class="form-check-input" type="checkbox" 
  id="CheckTasks" v-model='form.activeTasks'>
  <label class="form-check-label" for="CheckTasks">
    Active Tasks
  </label>
</div>  
                </div>
                </div>
                <div class="filter-content_border"></div>
                <div class="row">
                <div class="col-md-6">
                <h4>Search By Stage</h4>
                <select class="form-select" aria-label="Default select example" v-model="form.stage">
                <option selected value="">Choose from options</option>
    <option v-for="stage in stages" :key="stage.id" :value="stage.id">{{ stage.name }}</option>
    <option :key="0" :value="0">Close/postpone</option>
                </select>
                </div>
                <div class="col-md-5">
                   <h4>Search By Date</h4>
                <datetime type="date" value-zone="local" 
            zone="local" v-model="form.date">
                </datetime>
                 </div>
        <div class="col-md-1">
        <span class="form-date_close" @click.pervent="form.date = ''" v-if="form.date !== ''">x</span>
    </div>

                <!--<ul class="filter-list">
                <div v-for="stage in stages">
                <li class="filter-list_item">
                  <input class="form-check-input" type="radio"  id="stageRadio" v-model="form.stage" :value="stage.id" @click="toggleStage(stage.id)">
                {{stage.name}}
            </li>
           </div>
                <li class="filter-list_item">
                  <input class="form-check-input" type="radio" 
                  id="stageRadio" v-model="form.stage" value=0 
                  @click="toggleStage(0)">
                 Close/postpone
             </li>
                </ul>-->
            </div>
        <div class="filter-content_border"></div>
    <div class="row">
        <h4>Search By fields</h4>
    <div class="col-md-4">
    <input class="form-check-input" v-model="form.status" type="radio" id="statusCheck" value="hot" @click="toggleStatus('hot')">
    Hot Projects <span class="status-dot bg-red"></span>  
    </div>
    <div class="col-md-4">
    <input class="form-check-input" v-model="form.status" type="radio" id="statusCheck" value="cold" @click="toggleStatus('cold')">
    Cold Projects  <span class="status-dot bg-blue"></span>
    </div>
        <div class="col-md-4">
        <input class="form-check-input" type="checkbox" v-model="form.hasMembers" id="flexCheckDefault" >
  <label class="form-check-label" for="flexCheckDefault">
    Has Members
  </label>    
    </div>
    </div>
    <button class="float-right mt-4 mb-2 btn btn-primary btn-pill w-50" @click.pervent="filter">Filter</button>    
    </div>
   </div>
    </div>
    </div>
    <div class="ms-auto text-secondary">
    <button class="btn btn-sm btn-danger">Bulk Delete</button>
    </div>

    <div class="ms-auto text-secondary">
        Search:
    <div class="ms-2 d-inline-block">
    <input type="text" class="form-control form-control-sm" placeholder="By Project And User" name="search" autocomplete="off" v-model="searchTerm" @keydown="searchProjects()">
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
                            <i v-if="currentSort === 'asc' || currentSort === ''" class="fas fa-angle-up angle-pointer" @click="toggleSort('asc')"></i>

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
                        <div>{{project.owner.name}}</div>
                        <div>({{project.owner.username}})</div>
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
  import { debounce } from 'lodash';

export default{
    data(){
    return{
	   projects:[],
       stages:[],
       totalProjects:0,
       currentSort: 'asc',
       from:0,
       to:0,
       total:0,
       searchTerm:'',
       isPop:false,
       form:{
        projects:'',
        activeTasks:'',
        hasMembers:'',
        status:'',
        date:'',
        stage:'',
       }
    };
    }, 
    watch:{
        /*isPop(isPop){
            if(isPop){
            document.addEventListener('click', (event) => this.$options.methods.handleClickOutside.call(this, event, '.filter-dropdown', this.isPop));
            }
        }*/
    },
    methods:{
    loadStages(){
    axios.get('/api/v1/stages').
    then(response=>{
       this.stages=response.data;
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
    },
    toggleRadio(selectedValue) {
      if (this.form.projects === selectedValue) {
        this.form.projects = null;
      } else {
        this.form.projects = selectedValue;
      }
    },
    toggleStatus(selectedValue) {
      if (this.form.status === selectedValue) {
        this.form.status = null;
      } else {
        this.form.status = selectedValue;
      }
    },
    toggleStage(selectedValue) {
        console.log(selectedValue);
      if (this.form.stage === selectedValue) {
        this.form.stage = null;
      } else {
        this.form.stage = selectedValue;
      }
    },			
        getResults(page=1){
        const queryParameters = {
        page: page,
      };

       if (this.searchTerm) {
        queryParameters.search = this.searchTerm;
      }

      if (this.currentSort) {
        queryParameters.sort = this.currentSort;
      }

        axios.get(`/api/v1/admin/projects`,{
          params: queryParameters,
        })
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
    searchProjects:debounce(function () { 
      this.getResults();
    },1000),
    filter(){
        this.form={};
        this.form.date='';
        this.form.stage='';
        this.isPop=false;
    }
    },
    mounted(){
        this.getResults();
        this.loadStages();
    }
}
</script>
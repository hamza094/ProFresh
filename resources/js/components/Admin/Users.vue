<template>
	<div>
  <div class="page-top mb-4">Welcome To Tasks Panel</div>
   <div class="container">
     		<div class="row">
          <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Users</h3>
                  </div>

                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                    Search:
                <div class="ms-2 d-inline-block">
                <input type="text" class="form-control form-control-sm" placeholder="By Name" name="search" autocomplete="off" v-model="searchTerm" @keydown="searchUsers()">
              </div>

    <div class="ms-auto text-secondary"></div>
    </div>
    </div>
    <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
      <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                        <tr>
                          <th>Name</th>
                          <th>UserName</th>
                          <th>Avatar</th>
                          <th>Email</th>
                          <th>Timezone</th>
                          <th>Created At</th>
                          <th>IsSubscribed</th>
                          <th>Roles</th>
                          <th>Active Projects Count</th>
                          <th>Project Member</th>
                          <th>Last Active</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(user,index) in users.data" :key="user.id">
                        <td>
                           <router-link :to="'/user/'+user.id+'/profile'" class="admin-panel-link">
                        <div>{{user.name}}</div>
                        </router-link>
                        </td>
                          <td>{{user.username}}</td>
                          <td><img :src="user.avatar"></td>
                          <td>{{user.email}}</td>
                          <td>{{user.timezone}}</td>
                          <td>{{user.created_at}}</td>
                          <td>{{user.isSubscribed}}</td>
                          <td>
                          <div class="dropdown">
                          <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div v-if="!user.roles || user.roles.length === 0">
                              <span>Not Defined</span>
                            </div>
                            <div v-else>
                              <span v-for="role in user.roles">
                                <span>{{role.name}}</span>
                              </span>
                            </div> 
                        </a>
                          <div class="dropdown-menu dropdown-menu-end" style="">
                          <div v-for="role in roles" :key="role.id">
                            <a class="dropdown-item" @click="assignUserRole(role.id,user.id)">{{role.name}}</a>
                          </div>
                          </div>
                        </div>
                      </td>
                          <td>{{user.projects_count}}</td>
                          <td>{{user.projects_member}}</td>
                          <td>{{user.last_active}}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex">
     <p class="float-left">Showing <span>{{from}}</span> to {{to}}<span></span> of <span></span>{{total}} entries</p>
                        <pagination :data="this.users" @pagination-change-page="getResults()"></pagination>
                  </div>
                </div>
              </div>
     		</div>
        <div class="row mt-3">
          <div class="col-md-6">
           <div class="card">
             <div class="card-header">
               Roles
             </div>
             <div class="card-body">
               Add New Role
               <div class="ms-2 d-inline-block">
                <input type="text" class="form-control form-control-sm" name="role" v-model="form.role" autocomplete="off" @keyup.enter="addRole()">
              </div>
              <div class="mt-3">
                <div v-for="role in roles" :key="role.id" class="role-container">
  <div class="role-content">
    <p>{{ role.name }}</p>
    <div class="button-group">
      <div class="role-dropdown"
          @click="toggleDropdown(role.id)">
        <span class="btn btn-sm btn-primary" role="button">+</span>
        <div class="role-dropdown_item" v-show="isOpen[role.id]">
          <div class="role-dropdown_content">
            <ul class="role-list" v-for="permission in role.permissions">
              <li class="role-list_items">
                {{permission.name}} 
                <span class="btn btn-secondary btn-sm" @click.pervent="unAssignPermission(permission.id,role.id)">-</span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <button class="btn btn-sm btn-danger" @click="removeRole(role.id)">Delete</button>
    </div>
  </div>
</div>
                
              </div>
             </div>
           </div>            
          </div>
          <div class="col-md-6">
             <div class="card">
             <div class="card-header">
               Permissions
             </div>
             <div class="card-body">
               Add New Permission
               <div class="ms-2 d-inline-block">
                <input type="text" class="form-control form-control-sm" name="role" v-model="form.permission" autocomplete="off" @keyup.enter="addPermission()">
              </div>
              <div class="mt-3">
                <div v-for="permission in permissions" :key="permission.id">
                <p> 
                   <div class="dropdown">
                         {{permission.name}} <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assign to role
                          </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
        <div v-for="role in roles" :key="role.id">
            <!-- Check if user exists and has roles before accessing roles -->
            <a :class="{ 'dropdown-item': true, 'active': user && user.roles && hasRole(user.roles, role) }" @click="assignUserRole(role.id, user.id)">
                {{ role.name }}
            </a>
        </div>
    </div>
                  <span class="float-right">
                    <span><button class="btn btn-sm btn-danger" @click="removePermission(permission.id)">Delete</button></span>
                  </span>
                </div>
                </p> 
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
  import { debounce } from 'lodash';

export default{
    data(){
    return{
	    users:[],
      isOpen: {},
      from:0,
      to:0,
      total:0,
      searchTerm:'',
      roles:[],
      isPop:false,
      permissions:[],
      form:{
        role:'',
        permission:'',
      }
    };
    }, 
    watch:{
      isPop(isPop){
            if(isPop){
            document.addEventListener('click', (event) => this.$options.methods.handleClickOutside.call(this, event, '.role-dropdown', this.isPop));
            }
        }
    },
  methods:{
      toggleDropdown(roleId) {
    this.isOpen = {
      ...this.isOpen,
      [roleId]: !this.isOpen[roleId]
    };
  },
    hasRole(userRoles, loopRole) {
      return userRoles && userRoles.some(userRole => userRole.id === loopRole.id);
    },
      getResults(page = 1) {
      const queryParameters = {
        page: page,
        search:this.searchTerm,
      };

      const filteredParameters = Object.fromEntries(
      Object.entries(queryParameters).filter(([_, value]) => value !== undefined && value !== ''));

      axios.get('/api/v1/admin/users', {
        params: filteredParameters,
      })
      .then(response => {
      this.users = response.data || '';
      this.from = this.users.meta.from || '';
      this.to = this.users.meta.to || '';
      this.total = this.users.meta.total || '';
        })
        .catch(error => {
        });
    },
    searchUsers:debounce(function () { 
      this.getResults();
    },1000),
    addRole(){
      axios.post('/api/v1/admin/roles',{
        role:this.form.role
      })
      .then(response=>{
        this.$vToastify.success(response.data.message);
       this.form.role="";
       this.loadRoles();
   }).catch(error=>{
     console.log(error);
   });
    },
    addPermission(){
      axios.post('/api/v1/admin/permissions',{
        permission:this.form.permission
      })
      .then(response=>{
       this.$vToastify.success(response.data.message);
       this.form.permission="";
       this.loadPermissions();
   }).catch(error=>{
     console.log(error);
   });
    },
     loadPermissions(){
      axios.get('/api/v1/admin/permissions')
      .then(response=>{
       this.permissions=response.data.permissions;
   }).catch(error=>{
     console.log(error);
   });
    },
    loadRoles(){
      axios.get('/api/v1/admin/roles')
      .then(response=>{
       this.roles=response.data.roles;
   }).catch(error=>{
     console.log(error);
   });
    },
    removeRole(roleId){
    axios.delete('/api/v1/admin/roles/'+roleId)
      .then(response=>{
      this.$vToastify.success(response.data.message);
      this.loadRoles();
   }).catch(error=>{
     console.log(error);
   });
    },
    removePermission(permissionId){
    axios.delete('/api/v1/admin/permissions/'+permissionId)
      .then(response=>{
      this.$vToastify.success(response.data.message);
      this.loadPermissions();
   }).catch(error=>{
     console.log(error);
   });
    },
    updateRole(){
     console.log('update');
    },
    assignPermission(permissionId,roleId){
     axios.get('/api/v1/admin/assign/roles/'+roleId+'/permissions/'+permissionId)
      .then(response=>{
      this.$vToastify.success(response.data.message);
      this.loadPermissions();
   }).catch(error=>{
     console.log(error);
   });
    },
    unAssignPermission(permissionId,roleId){
    axios.get('/api/v1/admin/unAssign/roles/'+roleId+'/permissions/'+permissionId)
      .then(response=>{
      this.$vToastify.success(response.data.message);
      this.loadRoles();
   }).catch(error=>{
     console.log(error);
   });
    },
    assignUserRole(roleId,userId){
     axios.get('/api/v1/admin/assign/users/'+userId+'/roles/'+roleId)
      .then(response=>{
      this.$vToastify.success(response.data.message);
      this.loadUsers();
   }).catch(error=>{
     console.log(error);
   });
    },
    },
    mounted(){
      this.getResults();
      this.loadRoles();
      this.loadPermissions();
    }
}
</script>

<style>
.role-container {
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px; /* Adjust as needed */
}

.role-content {
  display: flex;
  align-items: center;
}

.button-group {
  display: flex;
  align-items: center;
}

.role-dropdown {
  /* Your existing styles for dropdown */
}

.btn-danger {
  margin-left: 10px; /* Adjust margin as needed */
}


</style>
<template>
	<div>
     <div class="page-top mb-4">Welcome To Your Dashboard</div>
   <div class="container">
     		<div class="row">
               <div class="col-md-4">
                <router-link to="/admin/projects" class="admin-dashboard-link">
                   <div class="card">
                  <div class="ribbon ribbon-top bg-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"></path></svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">Projects</h3>
                    <p class="text-secondary">Empower administrators with comprehensive project control, offering insights, filtering options, and member management capabilities.It's where you can keep an eagle eye on projects, </p>
                  </div>
                </div>
              </router-link>
               </div>
               <div class="col-md-4">
                 <router-link to="/admin/tasks" class="admin-dashboard-link">
                   <div class="card">
                  <div class="ribbon ribbon-top bg-yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-tree" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M9 6h11"></path>
   <path d="M12 12h8"></path>
   <path d="M15 18h5"></path>
   <path d="M5 6v.01"></path>
   <path d="M8 12v.01"></path>
   <path d="M11 18v.01"></path>
</svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">Tasks</h3>
                    <p class="text-secondary">The Tasks section enables granular task management. Admins can oversee, edit, and optimize individual tasks, improving project productivity.</p>
                  </div>
                </div>
              </router-link>
               </div>
                  <div class="col-md-4">
                  <router-link to="/admin/users" class="admin-dashboard-link">  
                   <div class="card">
                  <div class="ribbon ribbon-top bg-green">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
   <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
   <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
   <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
</svg>
                  </div>
                  <div class="card-body">
                    <h3 class="card-title">Users</h3>
                    <p class="text-secondary">The Users section manages user accounts, roles, permissions, and login options, maintaining a secure and organized user environment.</p>
                  </div>
                </div>
              </router-link>  
               </div>
     		</div>
    <div class="row row-cards mt-4">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar">
                             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tilt-shift" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M8.56 3.69a9 9 0 0 0 -2.92 1.95"></path>
   <path d="M3.69 8.56a9 9 0 0 0 -.69 3.44"></path>
   <path d="M3.69 15.44a9 9 0 0 0 1.95 2.92"></path>
   <path d="M8.56 20.31a9 9 0 0 0 3.44 .69"></path>
   <path d="M15.44 20.31a9 9 0 0 0 2.92 -1.95"></path>
   <path d="M20.31 15.44a9 9 0 0 0 .69 -3.44"></path>
   <path d="M20.31 8.56a9 9 0 0 0 -1.95 -2.92"></path>
   <path d="M15.44 3.69a9 9 0 0 0 -3.44 -.69"></path>
   <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Site Logs Viewer
                            </div>
                            <div class="text-secondary">
                              <a href="/log-viewer" class="btn btn-outline-primary w-100 btn-sm" target="_blank">View</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-24-hours" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 13c.325 2.532 1.881 4.781 4 6"></path>
   <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2"></path>
   <path d="M4 5v4h4"></path>
   <path d="M12 15h2a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-1a1 1 0 0 0 -1 1v1a1 1 0 0 0 1 1h2"></path>
   <path d="M18 15v2a1 1 0 0 0 1 1h1"></path>
   <path d="M21 15v6"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Database Backup
                            </div>
                            <div class="text-secondary">
                              <button href="" class="btn btn-outline-success w-100 btn-sm" target="_blank" @click.pervent="runBackup()">Run Backup</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-twitter text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 6l16 0"></path>
   <path d="M10 12l10 0"></path>
   <path d="M6 18l14 0"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Stages Panel
                            </div>
                            <Stage></Stage>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                   <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-twitter text-white avatar">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-align-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
   <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
   <path d="M4 6l16 0"></path>
   <path d="M10 12l10 0"></path>
   <path d="M6 18l14 0"></path>
</svg>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">
                              Statuses Panel
                            </div>
                            
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                </div>
<div class="row mt-5">
            <div class="col-md-6">
                <div class="card" style="height: 28rem">
                    <div class="card-header">
                        <div class="card-activity">
                            Activities
                        </div>
                    </div>
                      <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                        <div class="divide-y"> 
                          <div>
                            <div class="row">
                              <div class="col-auto">
                                <span class="avatar" style="background-image: url(./static/avatars/002f.jpg)"></span>
                              </div>
                              <div class="col">
                                <div class="text-truncate">
                                  <strong>Kellie Skingley</strong> closed a new deal on project <strong>Pen Pineapple Apple Pen</strong>.
                                </div>
                                <div class="text-secondary">2 days ago</div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            </div>
            <div class="col-md-6 mt5">
                Chart
            </div>
        </div>
            <div class="card mt-5">
                  <div class="card-header">
                    <h3 class="card-title">Invoices</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="text-secondary">
                        Show
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
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
                          <th class="w-1">No. 
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 15l6 -6l6 6"></path></svg>
                          </th>
                          <th>Invoice Subject</th>
                          <th>Client</th>
                          <th>VAT No.</th>
                          <th>Created</th>
                          <th>Status</th>
                          <th>Price</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="text-secondary">001408</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Icons</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-pl me-2"></span>
                            Tookapic
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            13 May 2018
                          </td>
                          <td>
                            <span class="badge bg-success me-1"></span> Paid Today
                          </td>
                          <td>$940</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-secondary">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                    <ul class="pagination m-0 ms-auto">
                    </ul>
                  </div>
                </div>
        </div>


 
	</div>
</template>
<script>
  import Stage from './Stage.vue'

export default{
  components: {Stage},
    data(){
    return{
	   		
    };
    },
    methods:{
    runBackup(){
    axios.get('/api/v1/admin/backup/database').
    then(response=>{
       
   }).catch(error=>{
     console.log(error.response.data.errors);
   });
    },		
			
			
    },
    mounted(){
    }
}
</script>
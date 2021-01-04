<template>
  <div>
<div class="task">
  <div class="task-top">
    <span><b>Tasks</b> <a data-toggle="collapse" href="#taskProject" role="button" aria-expanded="false" aria-controls="taskProject">
      <i class="fas fa-angle-down float-right"></i></a></span>
  </div>

  <!--Task -->
    <div class="collapse" id="taskProject">
    <div class="card card-body">
    <div class="task-add">
      <form class="" @submit.prevent="projectTask">
        <div class="form-group">
          <label for="body">Add New Task</label>
          <input type="text" class="form-control" name="body" v-model="form.body">
        </div>
  </form>
    </div>
    <div class="task-list">
      <p class="task-list_heading">Project Tasks</p>
      <div v-for="task in tasks" :key="task.id">
        <p class="task-list_text">
          <span v-if="editing == task.id">
            <textarea name="body" rows="1" cols="34" v-model="form.editbody"  v-text="task.body" style="resize: none;"></textarea>
            <span class="btn btn-link btn-sm" @click="taskUpdate(task.id,task)">Update</span>
           <span class="btn btn-link btn-sm" @click="editClose(task.id,task)">Cancel</span>
          </span>
          <span  v-else :class="{ 'task-list_text-body' : task.completed == true}">{{task.body}}</span>
          <span class="float-right">
          <span>
            <input  v-if="task.completed" class="form-check-input" type="checkbox" @change="taskUncomplete(task.id,task)"  checked>
            <input v-else class="form-check-input" type="checkbox"  name="completed" @change="taskComplete(task.id,task)">
          </span>
           <span @click="taskDelete(task.id)"><i class="far fa-trash-alt" style="color:#E74C3C"></i></span>
          <span @click="edit(task.id,task)"><i class="far fa-edit" style="color:#2980B9"></i></span>
          </span>
          <br>
          <span class="task-list_time"><i class="far fa-clock"></i> {{task.created_at | timeExactDate}}</span>
         </p>
      </div>
    </div>
  </div>
    </div>
</div>
<hr>

<!--Appointment-->
<div class="project-appointment">
  <div class="task-top">
    <p><b>Appointments</b> <span class="btn btn-link btn-lg float-right" @click="modalAppoint()">+</span></p>
    <span><a data-toggle="collapse" href="#appointmentProject" role="button" aria-expanded="false" aria-controls="appointmentProject">View all appointments</a></span>
  </div>
    <div class="collapse" id="appointmentProject">
    <div class="card card-body">
      <div class="" v-for="appointment in appointments" :key="appointment.id">
        <hr>

        <!--Appointmrnt Edit Form-->
        <div v-if="appointedit == appointment.id">
          <span class="form-inline mb-2"> <b> Title: </b> <input type="text" id="title" class="form-control" name="title" v-model="form.title" ></span>
          <span class="form-inline "> <b> Date: </b>  <datetime v-model="form.strtdt" format="yyyy-MM-dd"></datetime> <span>: {{appointment.strtdt | timeDate}}</span> </span>
          <span class="form-inline"> <b> Time: </b>  <datetime type="time" v-model="form.strttm" value-zone="local" zone="local"></datetime></span>
          <span class="form-inline"> <b> Timezone: </b>
            <select class="custom-select mb-2" id="timezone" name="timezone" v-model="form.zone" style="width:50%">
              <option v-for="timezone in timezones">{{timezone}}</option>
            </select>
          </span>
          <span class="form-inline mb-2"> <b> Location: </b><input type="text" id="location" class="form-control" name="location" v-model="form.location"></span>
          <span class="form-inline mb-2"> <b> Outcome: </b>
          <select class="custom-select" id="outcome" name="outcome" v-model="form.outcome" style="width:50%">
            <option value="Intrested">Intrested</option>
            <option value="Left Message">Left Message</option>
            <option value="No Response">No Response</option>
            <option value="Reported as spam">Reported as spam</option>
            <option value="Not Intrested">Not Intrested</option>
            <option value="Not able to reach">Not able to reach</option>
          </select>
        </span>
        <span class="form-inline" v-if="projectmembers == 0"><b>Member Attendes:</b> No project member has been found</span>
          <span v-else class="form-inline"> <b>Member Attendes: </b><select class="custom-select" id="attendees" name="attendees" v-model="form.user">
            <option v-for="user in projectmembers"  v-bind:value="user.id">{{user.name}}</option>
          </select>
        </span>

<span class="float-right"> <span class="btn btn-link btn-sm" @click.prevent="appointEditClose(appointment.id,appointment)">Cancel</span> <span class="btn btn-link btn-sm" @click.prevent="appointmentUpdate(appointment.id,appointment)">Update</span> </span>
</div>

        <!--Appointment show-->
        <div v-else>
          <p><span><b> {{appointment.title}}</b>
            <span v-if="getdate < appointment.strtdt" class="badge badge-success">Open</span>
            <span v-if="getdate > appointment.strtdt" class="badge badge-danger">Past</span>
          </span>
            <span class="float-right"> <span class="btn btn-link" @click.prevent="editAppoint(appointment.id,appointment)"><i class="far fa-edit"></i></span> <span class="btn btn-link" @click.prevent="deleteAppointment(appointment.id)"><i class="far fa-trash-alt"></i></span> </span>
          </p>
          <p>  <span><i class="far fa-clock"></i> {{appointment.strtdt | timeDate}}</span> at <span>{{appointment.strttm}}</span> with <span>{{appointment.zone}} timezone</span> </span></p>
          <p><span><i class="far fa-handshake"></i> {{appointment.outcome}}</span>
            <span class="float-right"><i class="fas fa-map-marker-alt"></i> {{appointment.location}}</span>
           </p>
           <p><i class="fas fa-users"></i>
             <span v-for="user in appointment.users" :key="user.id" class="mr-1">{{user.name}}.</span>
         </p>
         <p class="float-right">Created at: {{appointment.created_at | timeDate}}</p>
         </div>
      </div>

    </div>
    </div>
    <div>

      <!--Add Appointment model-->
      <modal name="project-appointment" height="auto" :scrollable="true" :shiftX="1" width="55%"
       class="model-desin"
       :clickToClose=false>
       <div class="panel-top_content">
           <span class="panel-heading">Add New Appointment</span>
           <span class="panel-exit float-right" role="button" @click="modalClose()">x</span>
       </div>
      <div class="container">
        <form action=""  @submit.prevent="createAppointment()">
        <div class="row mt-2">

          <div class="col-md-8">
            <div class="panel-form">
                        <div class="panel-top_content">
                            <div class="form-group">
                            <label for="title" class="label-name">Title:</label>
                            <input type="text" id="title" class="form-control" name="title" placeholder="Enter title of appointment" v-model="appointment.title" required>
                            <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
                            </div>
                           <div class="form-group">
                             <p><b>Appointment Time:</b></p>
                            <label for="strtdt" class="label-name">Date:</label>
                            <i class="far fa-calendar-alt"></i>  <datetime v-model="appointment.strtdt" format="yyyy-MM-dd" required></datetime>
                            <span class="text-danger font-italic" v-if="errors.strtdt" v-text="errors.strtdt[0]"></span>

                             <label for="strttm" class="label-name">Time:</label>
                              <i class="far fa-clock"></i> <datetime type="time" v-model="appointment.strttm" value-zone="local" zone="local" required></datetime>
                              <span class="text-danger font-italic" v-if="errors.strtdt" v-text="errors.strtdt[0]"></span>
                            </div>
                            <div class="form-group">
                              <label for="timezone" class="label-name">Timezone:</label>
                              <select class="custom-select" id="timezone" name="timezone" v-model="appointment.zone" required>
                                <option v-for="timezone in timezones">{{timezone}}</option>
                              </select>
                              <span class="text-danger font-italic" v-if="errors.zone" v-text="errors.zone[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="location" class="label-name">Where:</label>
                                <input type="text" id="location" class="form-control" name="location"  placeholder="Enter location of appointment" v-model="appointment.location" required>
                                <span class="text-danger font-italic" v-if="errors.location" v-text="errors.location[0]"></span>
                            </div>
                            <div class="form-group">
                               <label for="outcome" class="label-name">Outcome:</label>
                              <select class="custom-select" id="outcome" name="outcome" v-model="appointment.outcome" required>
                                <option value="Intrested">Intrested</option>
                                <option value="Left Message">Left Message</option>
                                <option value="No Response">No Response</option>
                                <option value="Reported as spam">Reported as spam</option>
                                <option value="Not Intrested">Not Intrested</option>
                                <option value="Not able to reach">Not able to reach</option>
                              </select>
                              <span class="text-danger font-italic" v-if="errors.outcome" v-text="errors.outcome[0]"></span>
                            </div>
                        </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
               <label for="attendees" class="label-name">Member Attendes:</label>
               <p v-if="projectmembers == 0">Invite project member to fix an appointment with them.</p>
              <select v-else class="custom-select" id="attendees" name="attendees" v-model="appointment.user">
                <option v-for="user in  projectmembers"  v-bind:value="user.id">{{user.name}}</option>
              </select>
              <span class="text-danger font-italic" v-if="errors.user" v-text="errors.user[0]"></span>
            </div>
          </div>
        </div>
        <div class="panel-bottom">
            <div class="panel-top_content float-right">
            <button class="btn panel-btn_close" @click.prevent="modalClose()">Cancel</button>
                <button class="btn panel-btn_save" type="submit">Save</button>
            </div>
        </div>
      </form>
      </div>
    </modal>
    </div>
    <hr>
    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>
    <form id="paper" method="post" @keyup.enter="leadNote">
      <textarea placeholder="Write project notes" id="text" name="notes" rows="4" v-model="form.notes"></textarea>
      <br>
  </form>
</div>

    </div>
    <hr>
    <div class="invite">
      <p><b>Project Invitations:</b></p>
      <input type="text" placeholder="Search user for invitation" class="form-control" v-model="query">
      <div class="invite-list">
        <ul v-if="results.length > 0 && query">
          <li v-for="result in results.slice(0,5)" :key="result.id">
              <div @click.prevent="inviteUser(result.url)">{{result.title}} ({{result.searchable.email}})</div>
          </li>
        </ul>
      </div>
    </div>
    <hr>
    <div class="project_members">
      <div class="task-top">
        <p><b>Project Members</b><a data-toggle="collapse" href="#memberProject" role="button" aria-expanded="false" aria-controls="memberProject">
          <i class="fas fa-angle-down float-right"></i></a></p>
      </div>
      <div class="collapse" id="memberProject">
      <div v-if="projectmembers == 0">
        <p class="text-center"><b>No project member has been found.</b></p>
      </div>
        <div v-else v-for="projectmembers in groupedMembers" class="row">
        <div v-for="member in projectmembers" class="col-md-6" style="position:inherit" :key="member.id">
          <div class="project_members-detail">
             <a v-bind:href="'/users/'+member.id+'/profile'" target="_blank"> <img src="https://i.ibb.co/51ZCLB8/download-1.jpg" alt="">
              <p> {{member.name}}</p>
              </a>
              <a v-if="project.owner" href="#" @click="cancelMembership(member.id,member)">x</a>
              </div>
        </div>
      </div>
</div>
    </div>
    <hr>
</div>
  </div>
</template>
<script>
export default{
  props:['project','members'],
  watch: {
  query(after, before) {
    this.searchUsers();
  },
},
  data(){
    return{
      form:{
        body:'',
        editbody:'',
        completed:'',
        title:'',
        strtdt:'',
        strttm:'',
        zone:'',
        location:'',
        outcome:'',
        user:'',
        notes:this.project.notes,
      },
      appointment:{
        title:'',
        strtdt:'',
        strttm:'',
        zone:'',
        location:'',
        outcome:'',
        user:'',
      },
      tasks:{},
      editing:0,
      appointedit:0,
      timezones:[],
      users:{},
      errors:{},
      appointments:{},
      getdate:moment().format("YYYY-MM-DD"),
      query: null,
    results: [],
    projectmembers:this.members
    }
  },
  computed:{
    groupedMembers() {
     return _.chunk(this.projectmembers, 2)
  }
  },

  methods:{
    loadTasks(){
       axios.get('/api/projects/'+this.project.id+'/tasks')
               .then(({data})=>(this.tasks=data));
      },
      loadUsers(){
         axios.get('/api/users')
                 .then(({data})=>(this.users=data));
        },
        loadAppoinments(){
          axios.get('/api/projects/'+this.project.id+'/appointments')
          .then(({data})=>(this.appointments=data));
        },
    projectTask(){
       axios.post('/api/projects/'+this.project.id+'/tasks',this.form)
          .then(response=>{
              this.$vToastify.success("Project Task added");
              this.form.body="";
              this.loadTasks();
          }).catch(error=>{
           this.errors=error.response.data.errors;
       });
    },
    taskDelete(id){
      axios.delete('/api/projects/'+this.project.id+'/tasks/'+id)
      .then(response=>{
          this.$vToastify.info("Project Task deleted");
          this.loadTasks();
      }).catch(error=>{
        this.$vToastify.warning("Task deletion failed");
      })
    },
    deleteAppointment(id){
      axios.delete('/api/projects/'+this.project.id+'/appointment/'+id)
      .then(response=>{
          this.$vToastify.info("Appointment deleted");
          this.loadAppoinments();
      }).catch(error=>{
        this.$vToastify.warning("Appointment deletion failed");
      })
    },
    taskComplete(id,task){
      axios.patch('/api/projects/'+this.project.id+'/tasks/'+id,{
        body:task.body,
        completed:true,
      }).then(response=>{
          this.$vToastify.success("Task Completed");
          this.loadTasks();

      }).catch(error=>{
        this.$vToastify.warning("Task Status Updated failed");
      })
    },
    taskUncomplete(id,task){
      axios.patch('/api/projects/'+this.project.id+'/tasks/'+id,{
        body:task.body,
        completed:false,
      }).then(response=>{
          this.$vToastify.info("Task Marked Uncomplete");
          this.loadTasks();
      }).catch(error=>{
        this.$vToastify.warning("Task Status Updated failed");
      })
    },
    edit(id,task){
      this.editing = id;
      this.form.editbody=task.body;
    },
    editAppoint(id,appointment){
      this.appointedit = id;
      this.form.title=appointment.title;
      this.form.strtdt='';
      this.form.strttm=appointment.strttm;
      this.form.zone=appointment.zone;
      this.form.location=appointment.location;
      this.form.outcome=appointment.outcome;
    },
    editClose(id,task){
      this.editing=false;
      this.form.editbody=task.body;
    },
    appointEditClose(id,appointment){
      this.appointedit=false;
      this.form.strtdt=appointment.strtdt;
      this.form.user='';
    },
    taskUpdate(id,task){
      axios.patch('/api/projects/'+this.project.id+'/tasks/'+id,{
        body:this.form.editbody,
      }).then(response=>{
          this.$vToastify.success("Task Updated");
          this.editing=false;
          task.body=this.form.editbody;
      }).catch(error=>{
        this.$vToastify.warning("Task Updated failed");
      })
    },
    appointmentUpdate(id,appointment){
      axios.patch('/api/projects/'+this.project.id+'/appointment/'+id,{
        title:this.form.title,
        strtdt:this.form.strtdt.substring(0,10),
        strttm:this.form.strttm.substring(11,16),
        zone:this.form.zone,
        location:this.form.location,
        outcome:this.form.outcome,
        user:this.form.user,
      }).then(response=>{
          this.$vToastify.success("Appointment Updated");
          this.appointedit=false;
          this.loadAppoinments();
          this.form.title=appointment.title;
          this.form.strtdt='';
          this.form.strttm=appointment.strttm;
          this.form.zone=appointment.zone;
          this.form.location=appointment.location;
          this.form.outcome=appointment.outcome;
          this.form.user='';
      }).catch(error=>{
        this.$vToastify.warning("Appointment Updated failed");
      })
    },
    modalAppoint(){
      this.$modal.show('project-appointment');
    },
    modalClose(){
      this.$modal.hide('project-appointment');
      this.appointment={};
      this.errors={};
    },
    createAppointment(){
      axios.post('/api/projects/'+this.project.id+'/appointment',{
        title:this.appointment.title,
        strtdt:this.appointment.strtdt.substring(0,10),
        strttm:this.appointment.strttm.substring(11,16),
        zone:this.appointment.zone,
        location:this.appointment.location,
        outcome:this.appointment.outcome,
        user:this.appointment.user
      }).then(response=>{
          this.$vToastify.success("Project appointment added");
          this.modalClose();
          this.loadAppoinments();
         }).catch(error=>{
           this.errors=error.response.data.errors;
      });
    },
    leadNote(){
      axios.patch('/api/projects/'+this.project.id+'/notes',{
        notes:this.form.notes,
      }).then(response=>{
          this.$vToastify.success("Notes Updated");
      }).catch(error=>{
        this.$vToastify.warning("Notes Updatation failed");
        this.form.notes=this.project.notes
      })
    },
    inviteUser(user){
      axios.post('/api/projects/'+this.project.id+'/invitations',{
        email:user,
      }).then(response=>{
        this.query='';
        this.results='';
          this.$vToastify.success("Project Invitation Sent");
      }).catch(error=>{
        this.query='';
        this.results='';
        console.log("Project Invitation Failed!");
      })

    },
    searchUsers() {
   axios.get('/api/users/search', { params: { query: this.query } })
   .then(response => this.results = response.data)
   .catch(error => {});
 },
 cancelMembership(id,member){
   var self = this;
   swal.fire({
  title: 'Cancel Membership',
  text: "Are you sure! You won't revert this!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Cancel membership!'
 }).then((result) => {
  if (result.value) {
  axios.get('/api/project/'+this.project.id+'/cancel/'+id).then(function(){
      self.projectmembers.splice(member);
      self.$vToastify.info("Project Member Removed");
}).catch(function(){
      swal.fire("Failed!","There was  an errors","warning");
  });
 }
 })
},
  },
  created(){
    this.loadTasks();
    this.loadUsers();
    this.loadAppoinments();
    this.timezones=momenttz.tz.names();
  },
}
</script>

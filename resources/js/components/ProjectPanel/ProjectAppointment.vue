<template>
<div class="project-appointment">

  <div class="task-top">
    <p><b>Appointments</b> 
    	<span class="btn btn-link btn-lg float-right" @click="modalAppoint()">+</span></p>
    <span>
    	<a data-toggle="collapse" href="#appointmentProject" role="button" aria-expanded="false" aria-controls="appointmentProject">View all appointments</a>
    </span>
  </div>

    <div class="collapse" id="appointmentProject">
    <div class="card card-body">
      <div class="" v-for="appointment in appointments" :key="appointment.id">
        <hr>

        <!--Appointmrnt Edit Form-->
        <div v-if="appointedit == appointment.id">

        <span class="form-inline mb-2"> <b> Title: </b> 
          	<input type="text" id="title" class="form-control" name="title" v-model="form.title">
        </span>

        <span class="form-inline "> <b> Date: </b>  
          	<datetime v-model="form.strtdt" format="yyyy-MM-dd"></datetime> <span>: {{appointment.strtdt | timeDate}}</span>
        </span>

        <span class="form-inline"> <b> Time: </b> 
           <datetime type="time" v-model="form.strttm" value-zone="local" zone="local"></datetime>
       </span>

          <span class="form-inline"> <b> Timezone: </b>
            <select class="custom-select mb-2" id="timezone" name="timezone" v-model="form.zone" style="width:50%">
              <option v-for="timezone in timezones">{{timezone}}</option>
            </select>
          </span>

          <span class="form-inline mb-2"> <b> Location: </b>
          	<input type="text" id="location" class="form-control" name="location" v-model="form.location">
          </span>

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

<span class="float-right"> 
	<span class="btn btn-link btn-sm" @click.prevent="appointEditClose(appointment.id,appointment)">Cancel</span> 

	<span class="btn btn-link btn-sm" @click.prevent="appointmentUpdate(appointment.id,appointment)">Update</span> 
</span>

</div>

        <!--Appointment show-->
        <div v-else>
          <p><span><b> {{appointment.title}}</b>
            <span v-if="getdate < appointment.strtdt" class="badge badge-success">Open</span>
            <span v-if="getdate > appointment.strtdt" class="badge badge-danger">Past</span>
          </span>

        <span class="float-right"> 
           <span class="btn btn-link" @click.prevent="editAppoint(appointment.id,appointment)"><i class="far fa-edit"></i></span>

            <span class="btn btn-link" @click.prevent="deleteAppointment(appointment.id)"><i class="far fa-trash-alt"></i></span> </span>
          </p>

        <p>
          <span><i class="far fa-clock"></i> {{appointment.strtdt | timeDate}}</span> at <span>{{appointment.strttm}}</span>
           with <span>{{appointment.zone}} timezone</span> </span>
       </p>

          <p>
          	<span><i class="far fa-handshake"></i> {{appointment.outcome}}</span>
            <span class="float-right"><i class="fas fa-map-marker-alt"></i> {{appointment.location}}</span>
           </p>

           <p>
           	 <i class="fas fa-users"></i>
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


</div>
</template>

<script>

export default {

    props:['project','members'],
    data() {
      return {
     form:{
        title:'',
        strtdt:'',
        strttm:'',
        zone:'',
        location:'',
        outcome:'',
        user:'',
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

      timezones:[],
      projectmembers:this.members,
      getdate:moment().format("YYYY-MM-DD"),
      appointedit:0,
      appointments:{},
      errors:{}
        };
    },
    methods: {
     loadAppoinments(){
       axios.get('/api/project/'+this.project.id+'/appointment')
          .then(({data})=>(this.appointments=data));
        },

     modalAppoint(){
      this.$modal.show('project-appointment');
    },

    modalClose(){
      this.$modal.hide('project-appointment');
      this.appointment={};
      this.errors={};
    },

    deleteAppointment(id){
      axios.delete('/api/project/'+this.project.id+'/appointment/'+id)
      .then(response=>{
          this.$vToastify.info("Appointment deleted");
          this.loadAppoinments();
      }).catch(error=>{
        this.$vToastify.warning("Appointment deletion failed");
      })
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

    appointEditClose(id,appointment){
      this.appointedit=false;
      this.form.strtdt=appointment.strtdt;
      this.form.user='';
    },

    appointmentUpdate(id,appointment){
      axios.patch('/api/project/'+this.project.id+'/appointment/'+id,{
        title:this.form.title,
        strtdt:this.form.strtdt.substring(0,10),
        strttm:this.form.strttm.substring(11,16),
        zone:this.form.zone,
        location:this.form.location,
        outcome:this.form.outcome,
        user:this.form.user,
      }).then(response=>{
        
         this.appoinmentUpdateSuccess(id,appointment);

      }).catch(error=>{
        this.$vToastify.warning("Appointment Updated failed");
      })
    },

    appoinmentUpdateSuccess(id,appointment){
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
    },
    
     modalClose(){
      this.$modal.hide('project-appointment');
      this.appointment={};
      this.errors={};
    },

      createAppointment(){
      axios.post('/api/project/'+this.project.id+'/appointment',{
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

   },

    created(){
     this.loadAppoinments();
     this.timezones=momenttz.tz.names();
    }
}
</script>	
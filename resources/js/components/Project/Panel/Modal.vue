<template>

    <div class="edit-border-top p-3 task-modal">
    <div class="edit-border-bottom">
        <div class="task-modal_content">
         <span v-if="editing == task.id">
            <input class="title-form form-control" name="title" v-model="form.title" v-text="task.title">

            <span class="btn btn-link btn-sm" @click="updateTitle(task.id,task)">Update</span>

           <span class="btn btn-link btn-sm" @click="closeTitleForm(task.id,task)">Cancel</span>
          </span>

           <span v-else class="task-modal_title" @click="openTitleForm(task.id,task)">{{task.title}}</span>

            <span class="task-modal_close float-right" role="button" @click.prevent="modalClose">x</span>
        </div>
        <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
    </div>
        <div class="panel-form mt-2">
          <div class="row">
          	<div class="col-md-8">
          		<div class="task-feature">
          			<!--<p>-->
          				<p>
          					<small><b>Label</b> </small>:
          					<span class="task-option_labels-component" @click="changeStatus(status)" :style="{backgroundColor: task.status.color}">{{task.status.label}}</span>
          					<small class="ml-2"><b>Members:</b></small>
          					<span class="task-member">M</span>
          					<span class="task-member">A</span> 
          					<span class="task-member">S</span> 
          					</p>

          				<p v-if="task.due_at"><small><b>Task due: </b> </small> {{task.due_at | datetime}}</p>

          				<p v-if="task.notified"><small><b>Notified: </b> </small>{{task.notified}} </p>

          				<p v-if="task.due_at"><small><b>Days Left: </b>{{this.remainingMessage}}  </small> </p>          				
          			<!--</p>-->
          		</div>
          		<div class="task-description">
          			 <p class="task-description_container"><span class="task-description_heading">Description:</span><span class="text-danger font-italic" v-if="errors.description" v-text="errors.description"></span></p>

                     <div v-if="edit == task.id">

                <vue-editor name="description" 
                v-model="form.description" :editorToolbar="customToolbar"></vue-editor>


            <span class="btn btn-link btn-sm" @click="updateDescription(task.id,task)">Update</span>

           <span class="btn btn-link btn-sm" @click="closeDescriptionForm(task.id,task)">Cancel</span>
          </span>
      </div>
            <div v-else>
            	<p class="task-description_content" @click="openDescriptionForm(task.id,task)" v-html="task.description"></p>
            </div>	

          		</div>
          	</div>
          	<div class="col-md-4">
          		<div class="task-option">
          			<span class="text-center ml-4"><b>Options</b></span>
          			<h5 class="text-center">Change Label</h5>
          			<ul class="task-option_labels">
          			<li v-for="status in statuses" :key="status.id">
                     <p class="task-option_labels-component" @click="changeStatus(status)" :style="{backgroundColor: status.color}">{{status.label}}
                     <span  v-if="task.status_id == status.id">
                       <i class="fas fa-check-circle" style="color: #2a971c;"></i>
                     </span>
                     </p>
          			</li>
          			</ul>
          			<ul class="task-option_features">
          				<li>
          				<button class="btn btn-sm btn-outline-primary btn-block member-dropdown" @click.prevent="memberPop = !memberPop">
          					<i class="fas fa-user-alt pr-1"></i> <b>Members</b>
          				</button>
          				<div class="member-dropdown_item" v-show=memberPop>
                        <p class="text-center m-1"><small><b>Assign Task To Member</b></small></p>
                        <input type="" placeholder="Search Members" class="form-control m-2" name="member">
                        <button class="btn btn-sm btn-primary float-right">Assign</button>
                       </div>
          			</li>
          			<li>
          				<button class="btn btn-sm btn btn-sm btn-outline-success btn-block" @click.prevent="datePop = !datePop">
          				  <i class="fas fa-clock pr-1"></i><b>Due Date</b>
          				</button>
          				<div class="member-dropdown_item" v-show=datePop>
                        <span>Due Date:
                        <datetime type="datetime" v-model="form.due_at" value-zone="local" zone="local" :min-datetime="modifiedDate"></datetime>
                        </span>
                        <select class="custom-select mr-sm-2" v-model="form.notified">
                         <option selected>Choose...</option>
                          <option value="1 Day Before">1 Day Before</option>
                          <option value="2 Hours Before">2 Hours Before</option>
                          <option value="15 Minutes Before">15 Minutes Before</option><option value="5 Minutes Before">5 Minutes Before</option>
                          <option value="At The Time">At The Time</option>
                         </select>
                         <div class="float-right mt-2">
                          <button class="btn btn-sm btn-secondary" @click.prevent="cancelDue()">Cancel</button>
                          <button class="btn btn-sm btn-primary" @click.prevent="taskDue(task.id,task)">Set</button>
                         </div>
                       </div>
          			</li>	
          			<li>
          				<button class="btn btn-sm btn btn-sm btn-outline-info btn-block" @click.prevent="inActive()">
          				  <i class="fas fa-ban pr-1"></i><b>	Inactive</b>
          				</button>
          			</li>
          			<li>	
          				<button class="btn btn-sm btn btn-sm btn-outline-danger btn-block" @click.prevent="trash()">
          				  <i class="fas fa-trash-alt pr-1"></i><b>	Delete</b>
          				</button>
          			</li>
          			</ul>

          		</div>
          	</div>
          </div>
        </div>
	</div>
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
	components: {VueEditor},

  props:['task','slug'],
    data() {
      return {
        editing:0,
        currentDate: new Date(),
        maxdateTime: null,
        edit:0,
        memberPop:false,
        datePop:false,
        statuses:'',
        due:'',
        form:{
          title:'',
          description:'',
          due_at:'',
          notified:'',
        },
		model:{},
        errors:{},
        customToolbar: [
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['blockquote'],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        ['link', 'unlink'],
      ]
        };
    },
    computed: {
  modifiedDate() {
    const modifiedDate = new Date(this.currentDate.getTime() + 30 * 60000);
    return modifiedDate.toISOString();
  },
  remainingMessage(){
    if(this.task.due_at !== null){
  	  const duration = this.calculateDuration();
      const timeRemaining = this.calculateTimeRemaining(duration);

      if (timeRemaining <= 0) {
        return 'Due date passed';
      }

      const message = this.formatRemainingTime(duration);

      return message;

  }
}
},
  methods: {
  	 calculateDuration() {
      return moment.duration(moment(this.task.due_at).diff(moment(this.currentDate)));
    },
    calculateTimeRemaining(duration) {
      return Math.floor(duration.asMinutes());
    },
     formatRemainingTime(duration) {
      const units = ['day', 'hour', 'minute'];
      const values = [duration.days(), duration.hours(), duration.minutes()];

      for (let i = 0; i < units.length; i++) {
        if (values[i] > 0) {
          return `${values[i]} ${units[i]}(s) remaining`;
        }
      }
    },
    taskDue(id,task){
     /*if(this.form.due_at == task.due_at){
  this.$vToastify.warning("Update not allowed. No changes were made.");
  return;
}*/

      axios.put(`/api/v1/projects/${this.slug}/task/${id}`,{
        due_at:this.form.due_at,
        notified:this.form.notified,
      }).then(response=>{
          this.$vToastify.success(response.data.message);
          task.due_at=this.form.due_at;
          task.notified=this.form.notified;
          this.cancelDue();
      }).catch(error=>{
          this.errors = error.response.data.errors;
      })
    },
    cancelDue(){
      this.datePop=false;
      this.form.notified='';
      this.form.due_at='';
      this.errors='';      
    },
  modalClose(){
   this.$modal.hide('task-modal');
   this.errors='';
	 this.form={
	 };
 },
 updateTitle(id,task){

if(this.form.title == task.title){
  this.$vToastify.warning("Update not allowed. No changes were made.");
  return;
}
      axios.put(`/api/v1/projects/${this.slug}/task/${id}`,{
        title:this.form.title,
      }).then(response=>{
          this.$vToastify.success(response.data.message);
          this.editing=false;
          task.title=this.form.title;
          this.errors='';
      }).catch(error=>{
          this.errors = error.response.data.errors;
      })
    },

    closeTitleForm(id,task){
      this.editing=false;
      this.form.title=task.title;
      this.errors='';
    },

    openTitleForm(id,task){
      this.editing = id;
      this.form.title=task.title;
    },

    updateDescription(id,task){
      if(this.form.description == task.description){
  this.$vToastify.warning("Update not allowed. No changes were made.");
  return;
}
      axios.put(`/api/v1/projects/${this.slug}/task/${id}`,{
        description:this.form.description,
      }).then(response=>{
          this.$vToastify.success(response.data.message);
          this.edit=false;
          task.description=this.form.description;
      }).catch(error=>{
          this.errors = error.response.data.errors;
      })
    },

    closeDescriptionForm(id,task){
      this.edit=false;
      this.form.description=task.description;
    },

    openDescriptionForm(id,task){
      this.edit = id;
      this.form.description=task.description;
    },

    assignMember(){
    	console.log('assign Member');
    },
    dueDate(){
    	console.log('due date');
    },

    inActive(){
    	console.log('in active');
    },
    trash(){
    	console.log('delete');
    },
    changeStatus(status){
    	console.log(status.label);
    },
    },
    mounted(){	 
    	axios.get('/api/v1/task/statuses')
    	.then(response=>{
             this.statuses=response.data;
    	}).catch({

    	});
    }
}
</script>

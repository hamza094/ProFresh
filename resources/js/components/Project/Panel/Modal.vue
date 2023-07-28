<template>

    <div class="edit-border-top p-3 task-modal">
    <div class="edit-border-bottom">
        <!-- Task Title Section -->
        <div class="task-modal_content">

          <!-- Edit Mode -->
         <span v-if="editing == task.id">

            <input class="title-form form-control" name="title" v-model="form.title" v-text="task.title">

            <span class="btn btn-link btn-sm" @click="updateTitle(task.id,task)">Update</span>

           <span class="btn btn-link btn-sm" @click="closeTitleForm(task.id,task)">Cancel</span>
          </span>

            <!-- View Mode -->
           <span v-else class="task-modal_title" @click="openTitleForm(task.id,task)">{{task.title}}</span>

            <span class="task-modal_close float-right" role="button" @click.prevent="modalClose">x</span>
        </div>

          <!-- Display error message for title -->
        <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
    </div>

        <!-- Task Details Section -->
        <div class="panel-form mt-2">
          <div class="row">
          	<div class="col-md-8">

              <!-- Task Features Section -->
          		<div class="task-feature">
          				<p>
          					<small><b>Label</b> </small>:
          					<span class="task-option_labels-component" :style="{backgroundColor: task.status.color}">{{task.status.label}}</span>
          					<small class="ml-2"><b>Members:</b></small>
                  
                      <span v-for="member in task.members" class="task-member-container" :key="member.id">
                    <router-link :to="`/user/${member.id}/profile`" class="task-member mr-1" target="_blank">{{ member.name.charAt(0) }}</router-link>
                    <span class="task-member-username">{{ member.username }}
      <span class="unassign-cross" @click="unassignMember(task.id,member.id)">&times;</span>
                    </span>
                    </span>
          					</p>

          				<p v-if="task.due_at"><small><b>Task due: </b> </small> {{task.due_at | datetime}}</p>

          				<p v-if="task.notified"><small><b>Notified: </b> </small>{{task.notified}} </p>

          				<p v-if="task.due_at"><small><b>Days Left: </b>{{this.remainingTime}}  </small> </p>

                </div>

          		<div class="task-description">
          			 <p class="task-description_container">
                  <span class="task-description_heading">Description:</span>
                  <span class="text-danger font-italic" v-if="errors.description" v-text="errors.description"></span>
                </p>

                <div v-if="edit == task.id">
              <!-- Vue editor for editing the description -->
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
                <!-- Change Label section -->
          			<span class="text-center ml-4"><b>Options</b></span>
          			<h5 class="text-center">Change Label</h5>
          			<ul class="task-option_labels">

                <!-- Task status labels -->
          			<li v-for="status in statuses" :key="status.id">
                     <p class="task-option_labels-component" @click="changeStatus(status.id,task,task.id)" :style="{backgroundColor: status.color}">{{status.label}}
                     <span  v-if="task.status_id == status.id">
                       <i class="fas fa-check-circle" style="color: #2a971c;"></i>
                     </span>
                     </p>
          			</li>

          			</ul>
          			<ul class="task-option_features">
          				<li>
                  <!-- Members dropdown -->
          				<button class="btn btn-sm btn-outline-primary btn-block member-dropdown" @click.prevent="memberPop = !memberPop">
          					<i class="fas fa-user-alt pr-1"></i> <b>Members</b>
          				</button>

                  <!-- Assign members section -->
          				<div class="member-dropdown_item" v-show=memberPop>
                    <p class="text-center m-1"><small><b>Assign Task To Member</b></small></p>

                     <input type="text" placeholder="Search Members" class="form-control" v-model="form.search" name="member" autocomplete="off">

                       <div v-if="hasError('members')">
    <span class="text-danger font-italic" v-for="error in getErrors('members')" :key="error">*{{ error }}</span>
  </div>

  <div v-if="hasError('members.0')">
    <span class="text-danger font-italic" v-for="error in getErrors('members.0')" :key="error">*{{ error }}</span>
  </div>

                <div class="member-list" v-if="searchResults.length > 0 && form.search">        
                <div v-for="member in searchResults" :key="member.id"
               class="member-list_items">
              <div @click.prevent="addMember(member,member.id)">{{member.name}} ({{member.username}})
              </div>
              </div> 
               </div>

                  <button class=" mt-2 btn btn-sm btn-primary float-right" @click="assignMembers(task.id)">Assign</button>

                    <div v-if="taskMembers.length > 0" class="mt-3" style="height:70px;width:150px; overflow-y:scroll;">

                      <div v-for="member in taskMembers">
                        <span>{{member.username}} <span @click.prevent="removeMember(member,member.id)"><i class="fas fa-minus-circle"></i></span> </span>
                      </div>
                    </div>
                  </div>

          			</li>

                <!-- Due Date section -->
          			<li>
          				<button class="btn btn-sm btn btn-sm btn-outline-success btn-block" @click.prevent="datePop = !datePop">
          				  <i class="fas fa-clock pr-1"></i><b>Due Date</b>
          				</button>
          				<div class="member-dropdown_item" v-show=datePop>
                        <span>Due Date:

                    <!-- Date picker for setting due date -->
                        <datetime type="datetime" v-model="form.due_at" value-zone="local" zone="local" :min-datetime="modifiedDate"></datetime>
                        </span>

                        <!-- Notification select dropdown -->
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
import { calculateRemainingTime } from '../../../utils/TaskUtils';
import { debounce } from 'lodash';

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
        isEditable: false,
        due:'',
        form:{
          title:'',
          description:'',
          due_at:'',
          notified:'',
          status_id:'',
          search:'',
        },
        searchResults:"",
        taskMembers: [], 
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
    watch:{
      'form.search': debounce(function(newSearch) {
      this.performSearch(newSearch);
    }, 500),
    },
    computed: {
  modifiedDate() {
    const modifiedDate = new Date(this.currentDate.getTime() + 30 * 60000);
    return modifiedDate.toISOString();
  },
  remainingTime(){
    return calculateRemainingTime(this.task, this.currentDate);
},
},
  methods: {
 updateTitle(id, task) {
    this.updateTask(
      id,task,{ title: this.form.title },
      () => {
        this.editing = false;
        this.errors = '';
      });
  },

  updateDescription(id,task){
    this.updateTask(
      id,task,{ description: this.form.description},
      () => {
        this.edit=false; 
        this.errors = '';
      });
  },

   changeStatus(statusId,task,id){
    this.updateTask(
      id,task,{ status_id:statusId},
      () => {
        this.edit=false; 
        this.errors = '';
      });
    },

    taskDue(id,task){
        this.updateTask(
      id,task,{ due_at:this.form.due_at,
        notified:this.form.notified,},
      () => {
        this.cancelDue();
      });
    },

updateTask(id, task, data,additionalCallback) {
  if (this.areObjectsEqual(data, task)) {
      this.$vToastify.warning("Update not allowed. No changes were made.");
      return;
  }

  axios.put(`/api/v1/projects/${this.slug}/task/${id}`, data)
    .then(response => {
      this.$vToastify.success(response.data.message);
       for (const key in response.data.task) {
        if (data.hasOwnProperty(key)) {
          task[key] = response.data.task[key];
        }
      }
      if (additionalCallback && typeof additionalCallback === 'function') {
        additionalCallback(response.data);
      }
    })
    .catch(error => {
      this.errors = error.response.data.errors;
    });
},

 areObjectsEqual(obj1, obj2) {
    return Object.keys(obj1).every(key => obj1[key] === obj2[key]);
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


    closeDescriptionForm(id,task){
      this.edit=false;
      this.form.description=task.description;
    },

    openDescriptionForm(id,task){
      this.edit = id;
      this.form.description=task.description;
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

  performSearch(searchTerm) {
    axios.get(`/api/v1/projects/${this.slug}/member/search`, {
        params: { search: this.form.search}
    })
    .then(response => {
        this.searchResults=response.data;
    })
    .catch(error => {
        console.log(error);
    });
},
addMember(member,id){
  this.taskMembers.push(member);
  this.searchResults=[];
  this.form.search='';
},
removeMember(member,id){
  this.taskMembers = this.taskMembers.filter((m) => m !== member);
},

    assignMembers(taskId){
      if(this.taskMembers.length == 0 ){
        return this.$vToastify.info('no member is selected to assign task')
      }
      const memberIds = this.taskMembers.map(member => member.id);

        axios.patch(`/api/v1/projects/${this.slug}/task/${taskId}/members`,{
              members:memberIds,
          }).then(response=>{
            this.taskMembers=[];
            this.task.members=response.data.taskMembers;
            this.errors='';
            this.$vToastify.success(response.data.message);
          }).catch(error=>{
             if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            }
          });
    },
    unassignMember(taskId,memberId){

      axios.patch(`/api/v1/projects/${this.slug}/task/${taskId}/unassign`,{
              member:memberId,
          }).then(response=>{
            this.task.members=response.data.members;
            this.$vToastify.success(response.data.message);
          }).catch(error=>{
            console.log(error);
          });
    },
      hasError(key) {
      return this.errors.hasOwnProperty(key);
    },
    getErrors(key) {
      if (this.hasError(key)) {
        return this.errors[key];
      }
      return [];
    },

    inActive(){
    	console.log('in active');
    },
    trash(){
    	console.log('delete');
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

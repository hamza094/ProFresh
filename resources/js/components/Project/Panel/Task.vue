<template>
	<div class="task">
  <div class="task-top">
    <span><b>Tasks</b> <a data-toggle="collapse" href="#taskProject" role="button" aria-expanded="false" aria-controls="taskProject">
      <i class="fas fa-angle-down float-right"></i></a></span>
  </div>

  <!--Task -->
    <div class="collapse" id="taskProject">
    <div class="card card-body">
    <div class="task-add">
      <form class="" v-if="access" @submit.prevent="add">
        <div class="form-group">
          <label for="body">Add New Task</label>
          <input type="text" class="form-control" name="body" v-model="form.body">
        </div>
  </form>
    </div>
    <div v-if="tasks" class="task-list">
      <p class="task-list_heading">Project Tasks</p>
      <div v-for="(task,index) in tasks.data" :key="task.id">
        <p class="task-list_text">
          <span v-if="editing == task.id">
            <textarea class="form-control" name="body" rows="1" cols="34" v-model="form.editbody"  v-text="task.body" style="resize: none;"></textarea>
            <span class="btn btn-link btn-sm" @click="update(task.id,task)">Update</span>
           <span class="btn btn-link btn-sm" @click="closeEditForm(task.id,task)">Cancel</span>
          </span>
          <span  v-else :class="{ 'task-list_text-body' : task.completed == true}">{{task.body}}</span>

          <span v-if="access" class="float-right">

          <span>
            <input  v-if="task.completed" class="form-check-input" type="checkbox" @change="markUncomplete(task.id,task)"  checked>
            <input v-else class="form-check-input" type="checkbox"  name="completed" @change="markComplete(task.id,task)">
          </span>

           <span @click="remove(task.id,index)"><i class="far fa-trash-alt" style="color:#E74C3C"></i></span>
          <span @click="openEditForm(task.id,task)"><i class="far fa-edit" style="color:#2980B9"></i></span>

          </span>
          <br>
          <span class="task-list_time"><i class="far fa-clock"></i> {{task.created_at}}</span>
         </p>
				 <hr>
      </div>
			<pagination :data="tasks" @pagination-change-page="getResults"></pagination>
    </div>
  </div>
    </div>
</div>
</template>
<script>
  export default {
    props:['slug','tasks','access'],
    data() {
      return {
        editing:0,
          form:{
          	body:'',
          	editbody:'',
          	completed:'',
          },
            errors:{}
        };
    },
    methods: {
		 getResults(page = 1) {
			 this.$bus.emit('taskResults',{page:page});
		},
     add(){
       axios.post('/api/v1/projects/'+this.slug+'/task',this.form)
          .then(response=>{
              this.$vToastify.success("Project Task added");
              this.form.body="";
							this.getResults();
              this.$bus.emit('addScore');
          }).catch(error=>{
						this.form.body="";
						this.taskErrors(error);
       });
    },
		url($slug,$id){
			return '/api/v1/projects/'+$slug+'/task/'+$id;
		},

      update(id,task){
      axios.put(this.url(this.slug,id),{
        body:this.form.editbody,
      }).then(response=>{
          this.$vToastify.success("Task Updated");
          this.editing=false;
          task.body=this.form.editbody;
      }).catch(error=>{
        this.taskErrors(error);
      })
    },

    closeEditForm(id,task){
      this.editing=false;
      this.form.editbody=task.body;
    },

    markComplete(id,task){
      axios.patch(this.url(this.slug,id)+'/status',{
        completed:true,
      }).then(response=>{
        this.$vToastify.success("Task Completed");
				task.completed=true;
      }).catch(error=>{
        this.$vToastify.warning("Task Status Updated failed");
      })
    },

    markUncomplete(id,task){
      axios.patch(this.url(this.slug,id)+'/status',{
        completed:false,
      }).then(response=>{
          this.$vToastify.info("Task Marked Uncomplete");
					task.completed=false;
      }).catch(error=>{
        this.$vToastify.warning("Task Status Updated failed");
      })
    },

    remove(id,index){
      axios.delete(this.url(this.slug,id))
      .then(response=>{
				 this.getResults();
         this.$vToastify.info("Project Task deleted");
           this.$bus.emit('reduceScore');
      }).catch(error=>{
        this.$vToastify.warning("Task deletion failed");
      })
    },

    openEditForm(id,task){
      this.editing = id;
      this.form.editbody=task.body;
    },
    taskErrors(error){
		if (!error.response) {
    this.$vToastify.warning("An error occurred.");
    return;
  }
  let errors = error.response.data.errors;
  if (errors) {
    for (let key in errors) {
      if (errors.hasOwnProperty(key)) {
        this.$vToastify.warning(errors[key][0]);
      }
    }
  } else {
    this.$vToastify.warning("An error occurred.");
  }
		},
    },
}
</script>

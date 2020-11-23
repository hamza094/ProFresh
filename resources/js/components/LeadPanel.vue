<template>
  <div>
<div class="task">
  <div class="task-top">
    <span>Tasks <a data-toggle="collapse" href="#taskLead" role="button" aria-expanded="false" aria-controls="taskLead">
      <i class="fas fa-angle-down float-right"></i></a></span>
  </div>

    <div class="collapse" id="taskLead">
    <div class="card card-body">
    <div class="task-add">
      <form class="" @submit.prevent="leadTask">
        <div class="form-group">
          <label for="body">Add New Task</label>
          <input type="text" class="form-control" name="body" v-model="form.body">
        </div>
  </form>
    </div>
    <div class="task-list">
      <p class="task-list_heading">Lead Tasks</p>
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
  </div>
</template>

<script>
export default{
  props:['lead'],
  data(){
    return{
      form:{
        body:'',
        editbody:'',
        completed:''
      },
      tasks:{},
      editing:0
    }
  },
  methods:{
    loadTasks(){
       axios.get('/api/leads/'+this.lead.id+'/tasks')
               .then(({data})=>(this.tasks=data));
      },
    leadTask(){
       axios.post('/api/leads/'+this.lead.id+'/tasks',this.form)
          .then(response=>{
              this.$vToastify.success("Lead Task added");
              this.form.body="";
              this.loadTasks();
          }).catch(error=>{
           this.errors=error.response.data.errors;
       });
    },
    taskDelete(id){
      axios.delete('/api/leads/'+this.lead.id+'/tasks/'+id)
      .then(response=>{
          this.$vToastify.info("Lead Task deleted");
          this.loadTasks();
      }).catch(error=>{
        this.$vToastify.warning("Task deletion failed");
      })
    },
    taskComplete(id,task){
      axios.patch('/api/leads/'+this.lead.id+'/tasks/'+id,{
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
      axios.patch('/api/leads/'+this.lead.id+'/tasks/'+id,{
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
    editClose(id,task){
      this.editing=false;
      this.form.editbody=task.body;
    },
    taskUpdate(id,task){
      axios.patch('/api/leads/'+this.lead.id+'/tasks/'+id,{
        body:this.form.editbody,
      }).then(response=>{
          this.$vToastify.info("Task Updated");
          this.editing=false;
          task.body=this.form.editbody;
      }).catch(error=>{
        this.$vToastify.warning("Task Updated failed");
      })
    },
  },
  created(){
    this.loadTasks();
  },
}
</script>

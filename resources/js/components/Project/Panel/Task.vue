<template>
	<div class="task">
  <div class="task-top">
    <span><i class="fas fa-tasks"></i> <b>Tasks</b> <a data-toggle="collapse" href="#taskProject" role="button" aria-expanded="false" aria-controls="taskProject">
      <i class="fas fa-angle-down float-right"></i></a></span>
  </div>

  <!--Task -->
    <div class="collapse" id="taskProject">
     <!-- <SubscriptionCheck> -->
    <div class="card card-body">
    <div class="task-add">
      <form class="" v-if="access" @submit.prevent="add">
        <div class="form-group">
          <label for="body"><i>Create a New Task</i></label>
          <input type="text" class="form-control" name="title" v-model="form.title">
        </div>
  </form>
    </div>
    <div v-if="tasks" class="task-list">
      <p class="task-list_heading"> Project Tasks</p>
       <div v-for="(task,index) in tasks.data" :key="task.id">
         <div class="card task-card_style" @click="openModal(task)">
          <div v-if="task.status" class="task-card_border" :style="{ 
            borderColor: task.status.color 
        }"></div>
          <div class="card-body task-card_body">
            <span>{{task.title}}</span>
          </div>
        </div>
      </div> 
       <modal name="task-modal" height="auto" :scrollable="true"
      width="65%" class="model-desin" :clickToClose=false >
      <div v-if="selectedTask">
        <TaskModal :task="selectedTask" :slug="slug"></TaskModal>
      </div>
    </modal>
			<pagination :data="tasks" @pagination-change-page="getResults"></pagination>
    </div>
  </div>
</SubscriptionCheck>
    </div>
</div>
</template>
<script>
  import TaskModal from './Modal.vue';
  import { mapMutations, mapActions } from 'vuex';
  //import SubscriptionCheck from '../../SubscriptionChecker.vue';

  export default {
    components:{TaskModal},
    props:['slug','tasks','access'],
    data() {
      return {
        task_score:2,
        selectedTask: null,
        form:{
          title:'',
        },
            errors:{}
        };
    },
    methods: {
      ...mapMutations('project',['addScore','reduceScore']),
      ...mapActions('project',['loadTasks']),

		 getResults(page = 1) {
      this.loadTasks({
        slug: this.slug,
        page: page
      });
    },
     openModal(task) {
      this.selectedTask = task;
      this.$modal.show('task-modal');
    },
     add(){
       axios.post('/api/v1/projects/'+this.slug+'/task',this.form)
          .then(response=>{
              this.$vToastify.success("Project Task added");
              this.form.title="";
							this.getResults();
              this.addScore(this.task_score);
          }).catch(error=>{
						this.form.title="";
						this.taskErrors(error);
       });
    },
		url($slug,$id){
			return '/api/v1/projects/'+$slug+'/task/'+$id;
		},

    remove(id,index){
      axios.delete(this.url(this.slug,id))
      .then(response=>{
				 this.getResults();
         this.$vToastify.info("Project Task deleted");
         this.reduceScore(this.task_score);
      }).catch(error=>{
        this.$vToastify.warning("Task deletion failed");
      })
    },

    /*taskErrors(error){
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
		},*/
    },
}
</script>


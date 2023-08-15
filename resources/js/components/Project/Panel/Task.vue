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
          <p class="task-list_heading"> {{this.message}}
    <div v-if="tasks" class="task-list">
        <span class="float-right">
          <a v-on:click.prevent="archiveTasks" class="panel-list_item">
          <i class="fas fa-tasks"></i>
         </a>
    </span>
  </p> 
       <div v-for="(task,index) in tasks.data" :key="task.id">
         <div class="card task-card_style" @click="openModal(task)">
          <div v-if="task.status" class="task-card_border" :style="{ 
            borderColor: task.status.color 
        }"></div>
          <div class="card-body task-card_body">
            <span>{{task.title}}</span>
            <span class="float-right mt-4"><small><i class="far fa-clock"></i>:{{task.created_at | date}}</small></span>
          </div>
        </div>
      </div>
       <modal name="task-modal" height="auto" :scrollable="true"
      width="65%" class="model-desin" :clickToClose=false @modal-closed="closeModal">
      <div v-if="selectedTask">
        <TaskModal :task="selectedTask" :slug="slug" :state="state"></TaskModal @modal-closed="closeModal">
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
  import { mapMutations, mapActions, mapState } from 'vuex';
  //import SubscriptionCheck from '../../SubscriptionChecker.vue';

  export default {
    components:{TaskModal},
    props:['slug','access'],
    data() {
      return {
        currentTasks: [],
        task_score:2,
        state:'active',
        selectedTask: null,
        form:{
          title:'',
        },
            errors:{}
        };
    },
    computed:{
    ...mapState('task',['tasks','message']),
  },
    methods: {
      ...mapActions('task', ['fetchTasks']),
      ...mapMutations('project',['addScore','reduceScore']),

		   getResults(page) {
        const slug = this.$route.params.slug;
        this.fetchTasks({ slug, page });
    },
      archiveTasks() {
        const panel1Handle = this.$showPanel({
          component: 'archive-tasks',
          openOn: 'right',
          width:440,
          disableBgClick:true,
          keepAlive:true,
          props: {
            slug: this.slug, 
          }
          })
          panel1Handle.promise
            .then(result => {

            });
          },
     openModal(task) {
      this.selectedTask = task;
      this.$modal.show('task-modal');
    },
     add(){
       axios.post('/api/v1/projects/'+this.slug+'/tasks',this.form)
          .then(response=>{
              this.$vToastify.success("Project Task added");
              this.form.title="";
							this.getResults(1);
              this.addScore(this.task_score);
          }).catch(error=>{
						this.form.title="";
            this.$vToastify.warning(error.response.data.message);
       });
    },
    closeModal() {
    this.selectedTask = null;
  },

  },
    created() {
    this.getResults(1);
  },
}
</script>


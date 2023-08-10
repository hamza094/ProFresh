<template>
  <div class="panel">
       <div class="panel-top">
          <div class="panel-top_content">
            <span class="panel-heading">Project Archived Tasks</span>
           <span class="panel-exit float-right" role="button" @click.prevent="closePanel">x</span>
          </div>
       </div>
          <div class="panel-top_content">
             <div  v-if="archivedTasks.length > 0">
       <div v-for="(task,index) in archivedTasks" :key="task.id">
         <div class="card task-card_style" @click="openModal(task)">
          <div v-if="task.status" class="task-card_border" :style="{ 
            borderColor: task.status.color 
        }"></div>
          <div class="card-body task-card_body">
            <span>{{task.title}}</span>
          </div>
        </div>
      </div>
      </div> 
      <div v-else>
          <p>Sorry, no tasks found.</p>
      </div>
      <modal name="archive-task-modal" height="auto" :scrollable="true"
      width="65%" class="model-desin archive-modal" :clickToClose=false @modal-closed="closeModal">
      <div v-if="selectedTask">
        <TaskModal :task="selectedTask" :slug="slug" :state="state"></TaskModal>
      </div>
    </modal>
          </div>


        </div>
    </div>
  </template>

<script>
    import TaskModal from './Modal.vue';
    import { mapState, mapMutations, mapActions } from 'vuex';

export default {
  components:{TaskModal},
  props:['slug'],
  data() {
    return {
      message: '',
      selectedTask: null,
      state:'archived',
    };
  },
  computed:{
    ...mapState('project',['archivedTasks']),
  },
  methods: {
    ...mapActions('project',['loadArchiveTasks']),

   closePanel(){
      this.$emit("closePanel", {});
   },
     openModal(task) {
      this.selectedTask = task;
      this.$modal.show('archive-task-modal');
    },
     closeModal() {
    this.selectedTask = null;
  },
  },
  created(){
    const slug = this.$route.params.slug;
      this.loadArchiveTasks(slug);
  },
};
</script>

<style scoped>
/* Your component-specific styles here */
</style>

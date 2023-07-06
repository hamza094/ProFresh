<template>
	<div>
		<!-- Task Modal-->
	 <modal name="task-modal" height="auto" :scrollable="true" 
	    width="45%" class="model-desin" :clickToClose=false >

    <div class="edit-border-top p-3 task-modal">
    <div class="edit-border-bottom">
        <div class="task-modal_content">
            <span class="task-modal_title">{{task.title}}</span>
            <span class="task-modal_close float-right" role="button" @click.prevent="modalClose">x</span>
        </div>
    </div>
        <div class="panel-form mt-2">
          <div class="row">
          	<div class="col-md-8">
          		<div class="task-feature">
          			<small>labels</small>
          			<p>{{task.status.label}} - {{task.status.color}}</p>
          		</div>
          		<div class="task-description">
          			<i class="fas fa-tasks-alt"></i> <h4>Descriprion</h4>
          			<p>Vestibulum vestibulum eu lacus eget sagittis. Suspendisse vel odio ornare, euismod leo sit amet, fermentum nulla. Sed vel viverra ipsum. Nam quis urna tellus. In non augue blandit dolor lacinia consectetur eget eu enim. Donec luctus lacus vel sem vulputate, at bibendum nunc hendrerit. Sed vel turpis augue. Nullam vitae libero eu mauris ultricies sagittis et quis quam. Praesent placerat metus at velit pellentesque scelerisque. Aliquam erat volutpat. Morbi in felis in quam maximus egestas.</p>
          		</div>
          	</div>
          	<div class="col-md-4">
          		<div class="task-option">
          			<small>Task Options</small>
          			<h6>Labels</h6>
          			<ul class="task-option_labels mb-2">
          				<li>Not Started</li>
          				<li>Started</li>
          				<li>In Progress</li>
          				<li>Completed</li>
          			</ul>
          			<ul>
          				<li>
          				<button class="btn btn-xs btn-secondary">
          					Members
          				</button>
          				<button class="btn btn-xs btn-info">
          					Due Date
          				</button>
          				<button class="btn btn-xs btn-warning">
          					Inactive
          				</button>
          				<button class="btn btn-xs btn-danger">
          					Delete
          				</button>
          			</li>
          			</ul>

          		</div>
          	</div>
          </div>
        </div>
  </div>
    </modal>


	</div>
</template>

<script>


export default {

  props:['task','slug'],
    data() {
      return {

        form:{},
		model:{},
        errors:{}
        };
    },
    methods: {
  modalClose(){
   this.$modal.hide('task-modal');
   this.errors='';
	 this.form={
	 };
 },
 

    }
}
</script>

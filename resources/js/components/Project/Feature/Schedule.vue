<template>
	<div>
   <a class="btn btn-link" @click.prevent="modalShow()"><i class="far fa-clock"></i></a>
		    <modal
name="view-schedules" height="auto" :scrollable="true"
	     class="model-desin"
	    :click-to-close=false width="75%">
	    <div class="edit-border-top p-3">
	    <div class="edit-border-bottom">
	        <div class="panel-top_content">
	            <span class="panel-heading">Scheduled messages</span>
	            <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
	        </div>
	    </div>

	  <div class="panel-top_content">

			<h2 v-if="messages == 0">Sorry no scheduled messages found</h2>

			<table v-else class="table table-bordered">
	  <thead>
	    <tr>
	      <th scope="col">Type</th>
	      <th scope="col">Message</th>
				<th scope="col">To</th>
	      <th scope="col">Scheduled At</th>
				<th scope="col">Created At</th>
				<th scope="col">Delete</th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr v-for="(message,index) in messages" :key="message.id">
	      <td>{{message.type}}</td>
	      <td>{{message.message}}</td>
				<td>
				<span v-for="user in message.users">
        <router-link :to="'/user/'+user.pivot.id+'/profile'" class="btn btn-link">
					{{user.name}}
				</router-link><br>
			</span>
			</td>
	      <td>{{message.delivered_at | datetime}}</td>
				<td>{{message.created_at | datetime}}</td>
				<td><a class="btn btn-danger" @click="remove(message.id,index)"><i class="fas fa-minus-circle"></i></a></td>
	    </tr>
	  </tbody>
	</table>

	  </div>

	  <div class="panel-bottom">
	      <div class="panel-top_content float-right">
	          <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
	      </div>
	  </div>

	  </div>
	    </modal>
		</div>
</template>

<script>

export default {
  props:['slug'],
    data() {
        return {
         messages:[],
          form:{

          },

            errors:{}
        };
    },
created(){
	this.scheduledMessages();
},
    methods: {
			modalShow(){
				 this.$modal.show('view-schedules');
			},
			scheduledMessages(){
				axios.get('/api/v1/projects/'+this.slug+'/messages/scheduled').
					then(response=>{
					this.messages=response.data;
					}).catch(error=>{
					console.log(error.response.data.errors);
					});
			},
			remove(id,index){
				axios.delete('/api/v1/projects/'+this.slug+'/messages/'+id+'/delete').
					then(response=>{
					   this.scheduledMessages();
					}).catch(error=>{
					console.log(error.response.data.errors);
					});
			},
    modalClose(){
   this.$modal.hide('view-schedules');
 },
},
}
</script>

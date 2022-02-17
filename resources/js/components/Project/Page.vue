<template>
	<div>
		<div class="container-fluid ">
				<div class="row">
						<div class="col-md-8 page pd-r">
								<div class="page-top">
										<div>
						<span>
								<span class="page-top_heading">Projects </span>
								<span class="page-top_arrow"> > </span>
								<span> {{project.name}}</span>
						</span>
						<span class="float-right">Project features with button</span>
										</div>
								</div>
								<div class="page-content">
										<div class="row">
												<div class="col-md-2">
	                     <Score :project='project' :points='project.score' :scores_detail='project.scores'>
					             </Score>
												</div>
												<div class="col-md-10">
													<div class="content">
													<p class="content-name">{{project.name}}</p>
													<p class="content-info">
													 Created On
													 <span class="content-dot"></span>
															{{project.created_at}}
													 </p>
													<p class="content-info">
													Created By<span class="content-dot"></span>
														  		 <a target="_blank" :href="user.id" class="btn btn-link">{{user.name}}</a>
															</p>
												</div>
													</div>
									 </div>
										<hr>
										<p class="pro-info">Project Detail</p>
										<div class="row">
												<div class="col-md-6">
													  <p  class="crm-info"> <b>About</b>: <span> {{project.about}} </span></p>
														<p v-if="!project.postponed" class="crm-info"> <b>Postponed reason</b>: <span> Not Defined  </span></p>
														<p v-else class="crm-info"> <b>Postponed reason</b>: <span> {{project.postponed}}  </span></p>
												</div>
												<div class="col-md-6">
														<p class="crm-info"> <b>Tasks</b>: <span> Info </span></p>
														<p class="crm-info"> <b>Appointments</b>: <span> Info </span></p>
														<p class="crm-info"> <b>Other</b>: <span> Info </span></p>
										</div>
										</div>
										<br>
										<Stage :project='project'></Stage>
										<br>
										<hr>
										<h3>RECENT ACTIVITIES</h3>
										<div class="row">
									 <div class="col-md-7 mb-5">
										 <div class="activity">
											<span>project activity card</span>
										</div>
									 </div>
									 <div class="col-md-5">
										 <span>project special features</span>
									 </div>
										</div>
								</div>
						</div>
						<div class="col-md-4 side_panel">
               Project Side Panel
							<br><br><br>
							<ul><b>Project todos:</b>
								<li>Project tasks</li>
								<li>Appointment</li>
               <li>Note</li>
							 <li>Invitations</li>
							 <li>Members</li>
							 <li>Online users</li>
							 <li>Real time chat</li>
							</ul>
							<h3>All this is Coming Soon...</h3>
						</div>
				</div>
		</div>
	</div>
</template>
<script>
	import Score from './Score'
	import Stage from './Stage'

export default{
	  components:{Score,Stage},
    data(){
    return{
     project:[],
		 scores:{},
		 user:{}
    };
    },
    methods:{
			loadProject(){
				 axios.get('/api/v1/projects/'+this.$route.params.slug).
				 then(response=>{
						 this.project=response.data;
						 this.user=response.data.user[0];
						 this.scores=this.project.scores;
				 }).catch(error=>{
					 console.log(error.response.data.errors);
				 });
			},

    },
    mounted(){
			this.loadProject();
    }
}
</script>

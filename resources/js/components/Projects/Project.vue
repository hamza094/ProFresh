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
													<span>Score with sum and messages</span>
												</div>
												<div class="col-md-10">
													<span>Project info</span>
													</div>
									 </div>
										<hr>
										<p class="pro-info">Project Detail</p>
										<span>Project detail</span>
										<br>
										<span>project stage </span>
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

export default{
    data(){
    return{
     project:[],
    };
    },
    methods:{
			loadProject(){
				 axios.get('/api/v1/projects/'+this.$route.params.slug).
				 then(response=>{
						 this.project=response.data;
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

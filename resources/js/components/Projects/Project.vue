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
										</div>
								</div>
								<div class="page-content">
										<div class="row">
												<div class="col-md-2">
												</div>
												<div class="col-md-10">
													</div>
									 </div>
										<hr>
										<p class="pro-info">Project Detail</p>
										Coming Soon ...
										<hr>
										<h3>RECENT ACTIVITIES</h3>
										<div class="row">
									 <div class="col-md-7 mb-5">
										 <div class="activity">
											Be Patient ...
										</div>
									 </div>
									 <div class="col-md-5">
										 Coming Soon...
									 </div>
										</div>
								</div>
						</div>
						<div class="col-md-4 side_panel">
               Project Side Panel
							<br><br><br>
							<h3>Coming Soon...</h3>
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

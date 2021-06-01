<template>
	<div>
     <div class="page-top">Welcome To Your Dashboard</div>
     	<div class="dashboard-project m-4">
     		<p class="dashboard-heading float-left"><b>Projects</b></p>
     			<span class="float-right">
     			<button class="btn btn-sm btn-primary">All Projects</button>
     			<button class="btn btn-sm btn-warning">Trashed Projects</button>
     			<button class="btn btn-sm btn-success">Invited Projects</button>
             	</span>
     	</div>
        <br><br>
     	<div class="dashboard">
     		<div class="row">
     			<div class="col-md-3">
                    <a href="" class="dashboard-link" target="_blank">
     				<div class="dashboard-projects mt-5">
                        <span class="float-right"><b>Active</b></span>
     					<p>Mehmantconsicous</p>
     					<p>Current Satge: Initial</p>
     					<p>Owner Name:Tomas Villa</p>
     					<P>Score:50</P>
     				</div>
                </a>
     			</div>
               <div class="col-md-3">
                    <a href="" class="dashboard-link" target="_blank">
                    <div class="dashboard-projects mt-5">
                        <span class="float-right"><b>Active</b></span>
                        <p>Mehmantconsicous</p>
                        <p>Current Satge: Initial</p>
                        <p>Owner Name:Tomas Villa</p>
                        <P>Score:50</P>
                    </div>
                </a>
                </div>
               <div class="col-md-3">
                    <a href="" class="dashboard-link" target="_blank">
                    <div class="dashboard-projects mt-5">
                        <span class="float-right"><b>Active</b></span>
                        <p>Mehmantconsicous</p>
                        <p>Current Satge: Initial</p>
                        <p>Owner Name:Tomas Villa</p>
                        <P>Score:50</P>
                    </div>
                </a>
                </div>
               <div class="col-md-3">
                    <a href="" class="dashboard-link" target="_blank">
                    <div class="dashboard-projects mt-5">
                        <span class="float-right"><b>Active</b></span>
                        <p>Mehmantconsicous</p>
                        <p>Current Satge: Initial</p>
                        <p>Owner Name:Tomas Villa</p>
                        <P>Score:50</P>
                    </div>
                </a> 
            </div>
     		</div>
     	</div>
        <div class="dashboard-project_info m-4">
        <p class="float-left"><b>Your Projects Info</b></p>
        <br>
        <div class="row">
            <div class="col-md-6">
            <ProjectChart> </ProjectChart>
            </div>
            <div class="col-md-6">
                <StatusChart> </StatusChart>
            </div>
        </div>
        </div>
	</div>

</template>


<script>

    import ProjectChart from './ProjectChart'    
    import StatusChart from './StatusChart'    

export default{
        components: {ProjectChart,StatusChart},

    data(){
    return{
    
    };
    },
    methods:{

    }
}
</script>

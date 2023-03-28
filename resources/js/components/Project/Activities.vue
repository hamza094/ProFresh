    <template>
    <div>
      <div class="container-fluid">
        <div class="row">
         <div class="col-md-8 page pd-r">
            <div class="page-top">
                        
     <div>
      <span>
      <span class="page-top_heading">Projects </span>
      <span class="page-top_arrow"> > </span>
       <span> <router-link :to="'/projects/'+this.$route.params.slug" 
    	class="dashboard-link">{{this.$route.params.name}}</router-link>
       </span>
       <span class="page-top_arrow"> > </span>
       <span>
       Activities >
       <span class="ml-2">{{this.current}}</span>
       </span>
       </span>
       </div>

      </div>

    <div class="container mt-3">
      <div class="activity mb-5">
        <div class="mt-3" v-if="this.activities.data == null">
            <h3 class="text-center">No related activities found</h3>
        </div>
        <ul>
        <li v-for="(activity,index) in this.activities.data" 
        :key="activity.id">
                <span class="activity-icon" :class="activityColor(activity.description)"> <i :class="activityIcon(activity.description)"></i></span>
                 {{activity.description}}
                  <p class="activity-info"><span v-text="activity.user.name"> </span><span class="activity-info_dot"></span><span v-text="activity.time"></span></p>
              </li>
          </ul>
      </div>
    </div>
    </div>
                <div class="col-md-4">
                    <div class="card">
                     <div class="card-header">
                       <p>Search Related Activities:</p>
                     </div>
                     <div class="card-body activity-search">
                       <ul>

                         <li>
                            <a href="" class="activity-icon_secondary" 
                           :class="{Activityfont:status == 'all'}"
                           @click.prevent="allActivities"><i class="fas fa-layer-group activity-icon_secondary mr-3" ></i>All Activities</a>
                        </li>

                         <li>
                            <a href="" class=" 'activity-icon_purple"
                            :class="{Activityfont:status == 'my'}"
                             @click.prevent="myActivities"><i class="fas fa-user activity-icon_purple mr-3"></i> My Activities</a>
                        </li>

                         <li>
                            <a href="" class="activity-icon_green" 
                            :class="{Activityfont:status == 'project'}"
                             @click.prevent="projectActivities"><i class="far fa-star activity-icon_green mr-3"></i> Project Activities</a>
                        </li>

                         <li>
                            <a href="" class="activity-icon_primary"
                            :class="{Activityfont:status == 'task'}" 
                             @click.prevent="taskActivities()"><i class="fas fa-tasks activity-icon_primary mr-3"></i> Task Activities</a>
                        </li>

                        <li>
                            <a href="" class="activity-icon_danger"
                            :class="{Activityfont:status == 'member'}" 
                            @click.prevent="memberActivities()">
                            <i class="fas fa-tasks activity-icon_danger mr-3"></i> Member Activities</a>
                        </li>
                       </ul>
                       
                     </div>
                    </div>
                    <div class="mt-4">
                     <pagination :data="activities" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

    	</div>
    </template>
<script>


export default{
    data(){
    return{
      	activities:{},
        status:'all',
        auth:this.$store.state.currentUser.user,
        current:'',
    };
    },
    methods:{
    // Fetch activities design from mixin
    activityIcon(description) {
        return this.getIcon(description);
    },
    
    activityColor(description) {
      return this.getColor(description);
    },

    async getData(suffix){
     await axios.get(`/api/v1/projects/${this.$route.params.slug}/activities${suffix}`).then(response=>{
                 this.activities=response.data;
            }).catch(error=>{
               console.log(error.response.data.errors);
            });
    },

	getActivities(){
	   this.getData('');
       this.current = 'All Project Activities';
	},

    getResults(page = 1) {
       this.getData(`?page=${page}`);
    },

    allActivities(){
       this.status = "all";
       this.getActivities();
    },

     myActivities(){
       this.status = "my";
       this.getData(`?mine=${this.auth.id}`);
       this.current = 'My Project Activities';
     },

     projectActivities(){
        this.status = "project";
        this.getData('?specifics=1');
        this.current = 'Project Specified Activities';
     },

     taskActivities(){
        this.status = "task";
        this.getData('?tasks=1');
        this.current = 'Project Tasks Activities';
     },

     memberActivities(){
       this.status = "member";
       this.getData('?members=1');
       this.current = 'Project Members Activities';
     }
    },

	created(){
       this.getActivities();
	},
}
</script>

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
       <span class="ml-2">{{this.currentTitle}}</span>
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
        <li v-for="activity in activityTypes" :key="activity.status">
        <a 
            href="#" 
            :class="['activity-icon_' + activity.color, { Activityfont: status === activity.status }]"
            @click.prevent="fetchActivities(activity)"
        >
            <i :class="['fas', activity.icon, 'mr-3', 'activity-icon_' + activity.color]"></i> 
            {{ activity.label }}
        </a>
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
  import activityMixins from '@/mixins/activityMixins';

export default{
    mixins: [activityMixins],
    data(){
    return{
      	activities:{},
        status:'all',
        auth:this.$store.state.currentUser.user,
        currentTitle: 'All Project Activities',
        currentQuery: '',
        activityTypes: activityMixins.data().activityTypes
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
      async getData(suffix) {
        await axios.get(`/api/v1/projects/${this.$route.params.slug}/activities${suffix}`)
            .then(response => {
                this.activities = response.data;
            })
            .catch(error => {
                console.log(error.response.data.errors);
            });
    },

    async fetchActivities(activity) {
            this.status = activity.status;
            this.currentTitle = activity.label;
            this.currentQuery = activity.query;
            this.getData(activity.query);
        }
        ,
         getResults(page = 1) {
            this.getData(`${this.currentQuery}&page=${page}`); 
        }
    },

	mounted() {
       this.fetchActivities(this.activityTypes[0]);
    },
}
</script>

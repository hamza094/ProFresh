<template>
 <div class="col-md-7 mb-5">
  <div class="activity">
   <ul>
    <li v-for="(activity,index) in this.activities" :key="activity.id">
        <span class="activity-icon" :class="activityColor(activity.description)"> <i :class="activityIcon(activity.description)"></i></span>
             {{activity.description}}
              <p class="activity-info"><span v-text="activity.user.name"> </span><span class="activity-info_dot"></span><span v-text="activity.time"></span></p>
          </li>

          <li><span class="activity-more">
            <router-link :to="'/project/'+this.name+'/'+this.slug+'/activities'" class="dashboard-link">View More</router-link>
          </span></li>
      </ul>
   </div>
  </div>
</template>

<script>
  export default{
    props:['activities','slug','name'],
    data(){
       return{
         icon:'',
       }
    },
    watch:{

    },
    methods:{
      activityIcon(description){
        if(description.startsWith("Task")){
         return 'fas fa-tasks';
       }
       if(description.startsWith("Project invitation") || description.startsWith("Project member")){
          return 'fas fa-user';
       }
       return 'fab fa-pagelines';
     },
     activityColor(description){
       if(description.startsWith("Task")){
         return 'activity-icon_primary';
       }
       if(description.startsWith("Project invitation") || description.startsWith("Project member")){
          return 'activity-icon_green';
       }
       return 'activity-icon_purple';
     }
 },
 mounted(){
    },
  }
</script>

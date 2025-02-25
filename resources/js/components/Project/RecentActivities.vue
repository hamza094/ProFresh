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
  import activityMixins from '@/mixins/activityMixins';

  export default{
    mixins: [activityMixins],
    props:['activities','slug','name'],
    data(){
       return{
         icon:'',
       }
    },
    watch:{

    },
    methods:{

      // Fetch activities design from mixin
      activityIcon(description) {
        return this.getIcon(description);
      },

      activityColor(description) {
        return this.getColor(description);
      },

 },
  }
</script>

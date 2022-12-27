<template>
   <div>
        <li class="dropdown  mr-5">

            <a href="#"  data-toggle="dropdown" class="notification">
               <i class="far fa-bell notification-icon"></i>
               <span v-if="notifications.length" class="notification-count">{{notifications.length}}</span>
            </a>
            <ul class="dropdown-menu notify-link  dropdown-menu-right rt">
                <li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">

            <router-link :to="(notification.data.link).slice(7)" >
                <a class="dropdown-item" @click="markAsRead(notification)">
                <b>{{notification.data.notifier.name}}</b> {{getPostBody(notification)}}
                </a>  
            </router-link>

         </li>
              <li v-if="!notifications.length" class="mt-2 mr-4 ml-4">No new notifications</li>
            </ul>
        </li>
   </div>
</template>

<script>
export default{
    data(){
        return{
            notifications:false
        }
    },
     created(){
        this.fetchNotifications();
        this.listenNotifications();
    },
    computed: {
      user:{
        get(){
          return this.$store.state.currentUser.user
        }
      },
      },
    methods:{
      fetchNotifications() {
           axios.get('/api/v1/user/' + this.user.id + '/notifications')
             .then(response => this.notifications = response.data);
       },
        markAsRead(notification)
        {
          axios.delete('/api/v1/user/'+this.user.id+'/notifications/'+notification.id).then(response => {
                this.notifications.splice(notification, 1);
            });
          },
        listenNotifications()
        {
          Echo.private('App.Models.User.'+this.user.id)
              .notification( notification => {
                this.$vToastify.success("You have one new notification");
                this.fetchNotifications();
          });
        },

        getPostBody(notification)
        {
          let body = this.stripTags(notification.data.message);
          return body.length > 40 ? body.substring(0, 40) + '...' : body;
        },

        stripTags(text)
        {
         return text.replace(/(<([^>]+)>)/ig, '');
        }
    }

}
</script>

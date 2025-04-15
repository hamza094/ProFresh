<template>
   <div>
        <li class="dropdown  mr-5">

            <a href="#"  data-toggle="dropdown" class="notification">
               <i class="far fa-bell notification-icon"></i>
               <span v-if="notifications.length" class="notification-count"></span>
            </a>
            <ul class="dropdown-menu  dropdown-menu-right rt">
            <div class="notify-link">
             <li class="notification-header">Notifications</li>
                <li v-if="!notifications.length" class="mt-2 mr-4 ml-4">No new notifications</li>

                <li v-for="notification in notifications" :key="notification.id" class="notification-list dropdown-item" 
                :class="{ 'notification-unread': !notification.read_at }">

              <router-link 
              :to="(notification.link).slice(7)"
               @click.native="markAsRead(notification)"
                class="notification-wrapper"
                >
                <img 
                     v-if="notification.notifier.avatar" 
                    :src="notification.notifier.avatar" 
                    :alt="notification.notifier.name" 
                    class="notification_avatar"
                />
             <div class="notification-content">
      <div class="notification-message">
        <strong>{{ notification.notifier.name }}</strong>
         {{ notification.message }}
        <span v-if="!notification.read_at" class="notification-unread_dot"></span>
      </div>
        <small class="notification-time"><i>{{ notification.created_at }}</i></small>
    </div>
           </router-link> 

         </li>
         <li v-if="notifications.length" class="notification-footer">
  <router-link to="/notifications" class="notification-footer_view-all-links">
    Show All Notifications
  </router-link>
</li>
</div>
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
           axios.get('/api/v1/users/' + this.user.uuid + '/notifications')
             .then(response =>{
                this.notifications = response.data;
                console.log(this.notifications);
            });
       },
        markAsRead(notification)
        {
          axios.delete('/api/v1/users/'+this.user.uuid+'/notifications/'+notification.id).then(response => {
            notification.read_at = new Date().toISOString();
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
         let body = this.stripTags(notification.message);

         return body.slice(0, 40) + (body.length > 40 ? '...' : '');
        },

        stripTags(text)
        {
         return text.replace(/(<([^>]+)>)/ig, '');
        }
    }

}
</script>

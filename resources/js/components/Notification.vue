<template>
   <div>
        <li class="dropdown mt-3 mr-4">
            <a href="#"  data-toggle="dropdown" class="notification">
               <i class="far fa-bell notification-icon"></i>
               <span v-if="notifications.length" class="notification-count">{{notifications.length}}</span>

            </a>
            <ul class="dropdown-menu  dropdown-menu-right rt">
                <li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">
    <a class="dropdown-item" :href="notification.data.link"  @click.prevent="markAsRead(notification)">
   <span><b>{{notification.data.notifier.name}}</b> {{getPostBody(notification)}}</span>
    </a>
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
          endpoint() {
              return `/profile/${window.App.user.id}/notifications`;
          }
      },
    methods:{
      fetchNotifications() {
           axios.get('/profile/' + window.App.user.id + '/notifications')
             .then(response => this.notifications = response.data);
       },
            markAsRead(notification){
              axios.delete('/profile/'+window.App.user.id+'/notifications/'+notification.id)
              .then(response => {
                  this.fetchNotifications();
                  document.location.replace(response.data.link);
              });
          },
        listenNotifications(){
            Echo.private('App.User.' + window.App.user.id)
                          .notification( notification => {
                          this.$vToastify.success("You have one new notification");
                          this.fetchNotifications();
                 });
                    },

    getPostBody (notification) {
    let body = this.stripTags(notification.data.message);

    return body.length > 40 ? body.substring(0, 40) + '...' : body;
    },
       stripTags (text) {
            return text.replace(/(<([^>]+)>)/ig, '');
        }
    }

}
</script>

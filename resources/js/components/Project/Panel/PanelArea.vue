<template>
  <div>
   <ProjectAppointment :project=project :members=members></ProjectAppointment>
    <hr>

    <div class="project-note">
      <div id="wrapper">
        <p><b>Add Project Note:</b></p>
    <form id="paper" method="post" @keyup.enter="leadNote">
      <textarea placeholder="Write project notes" id="text" name="notes" rows="4" v-model="form.notes"></textarea>
      <br>
  </form>
</div>
    </div>
    <hr>

    <div class="invite">
      <p><b>Project Invitations:</b></p>
      <input type="text" placeholder="Search user for invitation" class="form-control" v-model="query">
      <div class="invite-list">
        <ul v-if="results.length > 0 && query">
          <li v-for="result in results.slice(0,5)" :key="result.id">
              <div @click.prevent="inviteUser(result.url)">{{result.title}} ({{result.searchable.email}})</div>
          </li>
        </ul>
      </div>
    </div>
    <hr>

    <div class="project_members">
      <div class="task-top">
        <p><b>Project Members</b><a data-toggle="collapse" href="#memberProject" role="button" aria-expanded="false" aria-controls="memberProject">
          <i class="fas fa-angle-down float-right"></i></a></p>
      </div>

      <div class="collapse" id="memberProject">
      <div v-if="projectmembers == 0">
        <p class="text-center"><b>No project member has been found.</b></p>
      </div>

        <div v-else v-for="projectmembers in groupedMembers" class="row">
        <div v-for="member in projectmembers" class="col-md-6" style="position:inherit" :key="member.id">

          <div class="project_members-detail">
             <a v-bind:href="'/users/'+member.id+'/profile'" target="_blank">
             <img :src="member.avatar_path" v-if="member.avatar_path!=null" >
              <img v-else src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvsQZEtAw99ePVsNhLCexVsSKct6D13NluBQ&usqp=CAU" alt="">
              <p> {{member.name}}</p>
              </a>
              <a v-if="project.owner" href="#" @click="cancelMembership(member.id,member)">x</a>
              </div>
        </div>
      </div>
</div>
    </div>
    <hr>

<div>
  <p><b>Online Users</b></p>
  <p v-for="user in  chatusers">{{user.name}} <span class="chat-circle"></span> </p>
</div>

<ProjectChat :project='project' :projectgroup='projectgroup' :cons='cons'>
</ProjectChat>

</div>

</template>

<script>

import ProjectTasks from './ProjectTasks'
import ProjectAppointment from './ProjectAppointment'
import ProjectChat from './ProjectChat'

export default{
  props:['project','members','projectgroup','cons'],

  components:{ProjectTasks,ProjectAppointment,ProjectChat},

  watch: {
  query(after, before) {
    this.searchUsers();
  },
},
  data(){
    return{
      form:{
        user:'',
        notes:this.project.notes,
      },
      users:{},
      errors:{},
      query: null,
      results: [],
      projectmembers:this.members,
      user:window.App.user,
      chatusers:[],
    }
  },
  computed:{
    groupedMembers() {
     return _.chunk(this.projectmembers, 2)
  }
  },


  methods:{
      loadUsers(){
         axios.get('/api/users')
                 .then(({data})=>(this.users=data));
        },

    leadNote(){
      axios.patch('/api/projects/'+this.project.id+'/notes',{
        notes:this.form.notes,
      }).then(response=>{
          this.$vToastify.success("Notes Updated");
      }).catch(error=>{
        this.$vToastify.warning("Notes Updatation failed");
        this.form.notes=this.project.notes
      })
    },

    inviteUser(user){
      axios.post('/api/projects/'+this.project.id+'/invitations',{
        email:user,
      }).then(response=>{
         this.query='';
         this.results='';
         this.$vToastify.success("Project Invitation Sent");
      }).catch(error=>{
        this.$vToastify.warning("Project Invitation not Sent");
        console.log(error);
         this.query='';
         this.results='';
      })

    },

    searchUsers() {
   axios.get('/api/users/search', { params: { query: this.query } })
   .then(response => this.results = response.data)
   .catch(error => {});
 },

 cancelMembership(id,member){
   var self = this;
    this.sweetAlert('Yes, Cancel Membership!').then((result) => {
  if (result.value) {
  axios.get('/api/project/'+this.project.id+'/cancel/'+id).then(function(){
      self.projectmembers.splice(member);
      self.$vToastify.info("Project Member Removed");
}).catch(function(){
      swal.fire("Failed!","There was  an errors","warning");
  });
 }
 })
},

  listen(){
    Echo.join('chater').
      here((projectmembers)=>{
      this.chatusers=projectmembers;
      }).
      joining((user) => {
      this.chatusers.push(user);
      })
      .leaving((user) => {
      this.chatusers.splice(this.chatusers.indexOf(user),1);
    })
  },

  },
  created(){
    this.loadUsers();
    this.listen();

  },
}
</script>

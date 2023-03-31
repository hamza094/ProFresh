<template>
	<div>
	<div class="page-top">
	<span>
    <span class="page-top_heading">Profile </span>
    <span class="page-top_arrow"> > </span>
    <span> {{user.name}}</span>
    </span>
    <div v-if="owner" class="float-right">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-profile')">Edit Profile
    </button>

  <FeatureDropdown :featurePop="this.featurePop">
    <ul v-if="owner">
    <li v-if="user.avatar" class="feature-dropdown_item-content" @click="deleteAvatar"><i class="far fa-user-circle"></i> Remove Avatar</li>

    <li class="feature-dropdown_item-content" @click.prevent="deleteProfile()"><i class="far fa-trash-alt"></i>Delete Profile</li>
  </ul>
</FeatureDropdown>

</div>
		   </div>

 <EditProfile :user="user"></EditProfile>

	<div class="page-content">
	<div class="row">

	<UserAvatar :userId="user.id" :avatar="userAvatar" :name="user.name"></UserAvatar>

  <div class="col-md-10">
  <div class="content">
    <p class="content-name">{{user.name}}</p>
    <p class="content-info">
      <template v-if="user.info.company || user.info.position">
        <span v-if="user.info.company">{{ user.info.company }}</span>
        <span class="content-dot" v-if="user.info.company && user.info.position"></span>
        <span v-if="user.info.position">{{ user.info.position }}</span>
      </template>
      <span v-else>Not Defined</span>
    </p>
  </div>
</div>

    </div>
     <hr>
    <p class="pro-info">Profile Detail</p>
    <div class="row">
      <div class="col-md-6">

      <p class="crm-info"> <b>Email</b>: 
        <span> {{user.email}} </span>
      </p>

       <p class="crm-info"> <b>Mobile</b>:<span>
       {{ user.info.mobile ? user.info.mobile : 'Not Defined' }}</span></p>

        <p class="crm-info"> <b>Address</b>:<span>
        {{ user.info.address ? user.info.address : 'Not Defined' }}</span></p>

        <p class="crm-info"> <b>Created At</b>: <span> {{user.created_at}} </span></p>

        <p class="crm-info"> <b>Updated At</b>: <span> {{user.updated_at}} </span></p>

        <p class="crm-info"> <b>Last Seen</b>: <span> {{user.updated_at}} </span></p>
      </div>

        <div class="col-md-6">
        <p class="crm-info"> <b>Bio</b>:<span>{{ user.info.bio ? user.info.bio : "Donec in odio eget risus placerat molestie. Etiam augue turpis, tristique nec accumsan a, vehicula vitae quam. Sed imperdiet vulputate mi in molestie. Sed lacus quam, suscipit ut velit et, commodo sagittis leo."}}</span>
        </p>
        </div>
      </div>
  <hr>
<div v-if="owner">  
<ProjectInvitation :projects="invitations"></ProjectInvitation>
</div>
</div>
	</div>
</template>

<script>
  import EditProfile from './Edit'
  import UserAvatar from './Avatar'
  import ProjectInvitation from './ProjectInvitation.vue'
  import FeatureDropdown from '../FeatureDropdown.vue';
  import { permission } from '../../auth';
  import { mapState, mapMutations } from 'vuex';


export default{
  components: {EditProfile,UserAvatar,ProjectInvitation,FeatureDropdown},
	data(){
		return{
      auth:this.$store.state.currentUser.user.id,
      owner:false,
      featurePop:false,
		};
	},

	watch:{
        userPop(featurePop){
           document.addEventListener('click', (event) => this.$options.methods.handleClickOutside.call(this, event, '.feature-dropdown', this.featurePop));
        }
    },
    created(){
     this.loadUser();
    },

	methods:{
    ...mapMutations('profile',['updateUser', 'updateUserAvatar',
      'updateInvitations']),
   
        loadUser(){
         axios.get('/api/v1/users/'+this.$route.params.id).
         then(response=>{
          const user = response.data.user;
          this.updateUser(user);
          this.updateUserAvatar(user.avatar);
          this.updateInvitations(user.invited_projects);  
          this.owner = (this.user.id === this.auth);
         }).catch(error=>{
           console.log(error.response.data.errors);
         });
      },
    deleteAvatar(){
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      this.$vToastify.loader("Please Wait Removing Avatar");

      axios.patch('/api/v1/users/'+this.user.id+'/avatar_remove')
      .then((response) => {
        this.$vToastify.info(response.data.message);
        this.user.avatar=null;
        this.userAvatar=null;
        })
        .catch((error) => {
            swal.fire("Failed!","There was something wrong.","warning");
        })
        .finally(() => {
          this.$vToastify.stopLoader();
        });
      }
    })
  },

    deleteProfile(){
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.delete('/api/v1/users/'+this.user.id)
      .then((response) =>{
        this.$vToastify.success(response.data.message);
        this.$store.dispatch('currentUser/deleteUser');
      })
      .catch((error) =>{
          swal.fire("Failed!","There was something wrong.",
                    "warning");
      });
  }
    })
  },

    },

    computed: {
    ...mapState('profile',['user', 'userAvatar', 'invitations'])
  },
}	

</script>

<template>
	<div>
		<p>hy this is user profile Page</p>
		   <!--<div class="page-top">
		   	 <span>
                <span class="page-top_heading">Profile </span>
                <span class="page-top_arrow"> > </span>
                <span> {{user.name}}</span>
            </span>
            <div class="float-right" v-if="authorize('profileOwner',user)">
    <button class="btn btn-primary btn-sm" @click="$modal.show('edit-profile')">Edit Profile
    </button>
    <span class="feature-dropdown" @click="profilePop = !profilePop">
<span class="btn btn-light btn-sm"><i class="fas fa-cog"></i></span>
<span class="feature-dropdown_item" v-show=profilePop>
  <ul>
    <li v-if="user.avatar_path!==null" class="feature-dropdown_item-content" @click="deleteAvatar"><i class="far fa-user-circle"></i> Remove Avatar</li>

    <li class="feature-dropdown_item-content" @click.prevent="deleteProfile()"><i class="far fa-trash-alt"></i>Delete Profile</li>
  </ul>
</span>
    </span>
</div>
		   </div>

 <EditProfile :user="user"></EditProfile>

	<div class="page-content">
	<div class="row">
	<ProfileAvatar :user="user"></ProfileAvatar>

               <div class="col-md-10">
                            <div class="content">
                                <p class="content-name">{{user.name}}</p>
                                <p class="content-info">
                                <span v-if="user.company==null">Not Defined</span>
                                  <span v-else>{{user.company}}</span>
                                  <span class="content-dot"></span>
                                  <span v-if="user.position==null">Not Defined</span>
                                  <span v-else>{{user.position}}</span>
                                </p>
                            </div>
                          </div>
        </div>
<hr>
           <p class="pro-info">Profile Detail</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="crm-info"> <b>Email</b>: <span> {{user.email}} </span></p>
                                    <p class="crm-info"> <b>Mobile</b>:
                                     <span v-if="user.mobile==null"> Not Defined </span>
                                      <span> {{user.mobile}} </span>
                                    </p>
                                    <p class="crm-info"> <b>Address</b>:
                                      <span v-if="user.address==null"> Not Defined </span>
                                      <span v-else> {{user.address}} </span>
                                    </p>
                                    <p class="crm-info"> <b>Created At</b>: <span> {{user.created_at | timeDate}} </span></p>
                                    <p class="crm-info"> <b>Updated At</b>: <span> {{user.updated_at | timeDate}} </span></p>
                                    <p class="crm-info"> <b>Last Seen</b>: <span> {{user.updated_at | timeExactDate}} </span></p>
                                </div>
                                <div class="col-md-6">
                              <p class="crm-info"> <b>Bio</b>:<span v-if="user.bio==null">"Donec in odio eget risus placerat molestie. Etiam augue turpis, tristique nec accumsan a, vehicula vitae quam. Sed imperdiet vulputate mi in molestie. Sed lacus quam, suscipit ut velit et, commodo sagittis leo. Nunc tristique odio nec justo tempor maximus. Praesent id nisl nulla. Quisque vestibulum massa felis, in pellentesque justo varius ut. Donec nibh massa, viverra quis convallis in, dictum sed metus. Aliquam ut ullamcorper tortor. Pellentesque sagittis dolor turpis, eu dictum risus lacinia ut"</span>
                                <span v-else>"{{user.bio}}"</span>
                              </p>
                            </div>
                          </div>
          <hr>
<ProjectInvitation :user="user" :members="members"></ProjectInvitation>
</div>-->
	</div>
</template>

<script>
/*  import EditProfile from './EditProfile'
  import ProfileAvatar from './ProfileAvatar'
  import ProjectInvitation from './ProjectInvitation'

export default{
	props:['user','members'],
	components: {EditProfile,ProfileAvatar,ProjectInvitation},
	data(){
		return{
            avatar_path:this.user.avatar_path,
            profilePop:false,
		};
	},

	watch:{
        userPop(profilePop){
            if(profilePop){
                document.addEventListener('click',this.closeIfClickedOutside);
            }
        }
    },

	methods:{

        closeIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.profilePop=false;
                document.removeEventListener('click',this.closeIfClickedOutside);
            }
        },

      deleteAvatar(){
      var self = this;
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.patch('/api/user/'+this.user.id+'/avatar-delete').then(function(){
       self.redirectSuccess('Project avatar has been deleted',
        '/api/profile/user/'+this.user.id);
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

    deleteProfile(){
      var self = this;
      this.sweetAlert('Yes, delete it!').then((result) => {
      if (result.value) {
      axios.delete('/api/profile/user'+this.user.id).then(function(){
      self.redirectSuccess('Profile deleted successfully','/');
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

    }
}	*/

</script>

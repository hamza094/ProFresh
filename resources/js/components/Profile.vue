<template>
	<div>
		   <div class="page-top">
		   	 <span>
                <span class="page-top_heading">Profile </span>
                <span class="page-top_arrow"> > </span>
                <span> {{user.name}}</span>
            </span>
            <div class="float-right" v-if="authorize('profileOwner',owner)">
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

  <modal name="edit-profile"
           height="auto" :scrollable="true" :shiftX=".98" width="38%"
            class="model-desin" :clickToClose=false>
        <div class="edit-border-top p-3 animate__animated animate__slideInRight">
            <div class="edit-border-bottom">
                <div class="panel-top_content">
                    <span class="panel-heading">Edit Profile {{user.name}}</span>
                    <span class="panel-exit float-right" role="button" @click.prevent="modalClose">x</span>
                </div>
            </div>
            <div class="panel-form">
                    <form action="" @submit.prevent="updateProfile">
                        <div class="panel-top_content">

                            <div class="form-group">
                                <label for="lastname" class="label-name">Name:</label>
                                <input type="text" id="lastname" class="form-control"  name="name"
                                v-model="form.name">
                                <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="email" class="label-name">Email:</label>
                                <input type="text" id="email" class="form-control" name="email" v-model="form.email">
                                <span class="text-danger font-italic" v-if="errors.email" v-text="errors.email[0]"></span>

                            </div>

                            <div class="form-group">
                                <label for="company" class="label-name">Company:</label>
                                <input type="text" id="company" class="form-control" name="company"
                                v-model="form.company">
                                <span class="text-danger font-italic" v-if="errors.company" v-text="errors.company[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="mobile" class="label-name">Mobile:</label>
                                <input type="text" id="mobile" class="form-control" name="mobile"  v-model="form.mobile">
                                <span class="text-danger font-italic" v-if="errors.mobile" v-text="errors.mobile[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="position" class="label-name">Position:</label>
                                <input type="text" id="position" class="form-control" v-model="form.position">
                                <span class="text-danger font-italic" v-if="errors.position" v-text="errors.position[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="address" class="label-name">Address:</label>
                                <input type="text" id="address" class="form-control" 
                                v-model="form.address">
                                <span class="text-danger font-italic" v-if="errors.address" v-text="errors.address[0]"></span>
                            </div>

                            <div class="form-group">
                                <label for="status" class="label-name">Password:</label>
                                <input type="password" id="password" class="form-control" name="password" v-model="form.password">
                                <span class="text-danger font-italic" v-if="errors.password" v-text="errors.password[0]"></span>
                            </div>

                              <div class="form-group">
                                <label for="bio" class="label-name">Your Bio:</label>
                                <textarea type="text" v-model="form.bio" id="bio" name="bio" class="form-control">{{user.bio}}</textarea>
                                <span class="text-danger font-italic" v-if="errors.bio" v-text="errors.bio[0]"></span>
                            </div>

                        </div>
                        <div class="panel-bottom">
                            <div class="panel-top_content float-right">
                                <button class="btn panel-btn_close" @click.prevent="modalClose">Cancel</button>
                                <button class="btn panel-btn_save">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </modal>


		   <div class="page-content">
		   	<div class="row">
<div class="col-md-2">
		<div class="img-avatar" @click="$modal.show('avatar-file')" 
		v-if="authorize('profileOwner',owner)">
            <div class="img-avatar_name" v-if="user.avatar_path==null">
                {{user.name.substring(0,1)}}
            </div>
                <div v-else>
                    <img :src="avatar_path" alt="" class="main-profile-img"/>
                </div>
            <div class="img-avatar_overlay">
                <div class="img-avatar_overlay-text">Update</div>
            </div>
            </div>

            <div class="img-avatar" v-else>
            <div class="img-avatar_name" v-if="user.avatar_path==null">
                {{user.name.substring(0,1)}}
            </div>
                <div v-else>
                    <img :src="avatar_path" alt="" class="main-profile-img"/>
                </div>
            </div>
            
            	  <modal name="avatar-file" height="auto">
            <div class="p-3 bg-white shadow rounded-lg img_avarar">
                <input type="file" name="avatar" id="file" accept="image/*" value="Upload Avatar" @change="setImage"/>
                <!-- Image previewer -->

                <img :src="imageSrc" width="100" />

                <!-- Cropper container -->
                <div
                    v-if="this.imageSrc"
                    class="my-3 d-flex align-items-center justify-content-center mx-auto">
                    <vue-cropper
                        class="mr-2 w-50"
                        ref="cropper"
                        :guides="true"
                        :src="imageSrc"
                        :aspectRatio="0.9"
                    ></vue-cropper>

                    <!-- Cropped image previewer -->
                    <img class="ml-2 w-50 bg-light" :src="croppedImageSrc" />
                </div>
                <button  class="btn panel-btn_close" v-if="this.imageSrc" @click="cropImage">Crop</button>
                <button class="btn panel-btn_save" v-if="this.croppedImageSrc" @click="uploadImage()">Upload</button>
            </div>
        </modal>


            </div>
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
              <p class="pro-info">Project Invitations</p>

              <div v-if="authorize('profileOwner',owner)">
<div class="row" v-if="this.members != 0">
<div class="col-md-5 ml-3" v-for="member in this.members">
  <div class="card" v-if="member.pivot.active == 0" :id="'project-'+member.id">
     <p class="mt-3">Project Name: <a v-bind:href="'/api/projects/'+member.id" target="_blank"><b>{{member.name}}</b></a></p>
     <p>Owner Name: <a v-bind:href="'/user/'+member.id+'/profile'" target="_blank"><b>{{member.owner.name}}</b></a></p>
        <p>Invitation Received On: <b>{{member.pivot.created_at | timeDate}}</b></p>
  <p class="text-center"><button class="btn btn-primary btn-sm" @click.prevent="becomeMember(member.id)">Become Member
  </button>
<button class="btn btn-danger btn-sm" @click.prevent="rejectInvitation(member.id)">Ignore Invitation</button></p>
   <div class="card-footer">
   <p>
    <span class="float-right">Created_at: <b>{{member.created_at | timeExactDate}}</b></span>
</p>
    </div>
</div>
</div>
</div>
<div v-else>
  <h3>No project Invitation found</h3>
</div>
</div>
   </div>

	</div>

</template>

<script>
	import VueCropper from "vue-cropperjs"

export default{
	props:['user','members'],
	components: {
        VueCropper,
    },
	data(){
		return{
			owner:this.user,
			imageSrc: "",
            croppedImageSrc: "",
            avatar_path:this.user.avatar_path,
            profilePop:false,
            errors:{},
           form:{
              name:this.user.name,
              email:this.user.email,
              company:this.user.company,
              mobile:this.user.mobile,
              position:this.user.position,
              address:this.user.address,
              password:this.user.password,
              bio:this.user.bio,
          },
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
		  setImage(e) {
            const file = e.target.files[0]
            if (!file.type.includes("image/")) {
                alert("Please select an image file")
                return
            }
            if (typeof FileReader === "function") {
                const reader = new FileReader()
                reader.onload = event => {
                    this.imageSrc = event.target.result

                    // Rebuild cropperjs with the updated source
                    this.$refs.cropper.replace(event.target.result)
                }
                reader.readAsDataURL(file)
            } else {
                alert("Sorry, FileReader API not supported")
            }
        },
         cropImage() {
            // Get image data for post processing, e.g. upload or setting image src
            this.croppedImageSrc = this.$refs.cropper.getCroppedCanvas().toDataURL();
        },
        uploadImage() {
            Vue.prototype.$userId=this.user.id;

            this.$vToastify.info({
                title:'Loading...',
                body:'User Avatar Uploading',
                position:"bottom-left",
                theme:"light",
                duration:3000,
                mode:"loader",
            });


            this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
                    var profile=Vue.prototype.$userId;
                let formData = new FormData()
                // Append image file
                formData.append("avatar", blob)

                axios.post('/api/user/'+profile+'/avatar', formData)
                    .then(response=>{
                        window.location.reload();
                    })
                    .catch(function (error) {
                        //Vue.prototype.$notif;
                    })
            })

        },
         closeIfClickedOutside(event){
            if(!event.target.closest('.feature-dropdown')){
                this.profilePop=false;
                document.removeEventListener('click',this.closeIfClickedOutside);
            }
        },
        updateProfile(){
         alert('hello');
        },
        modalClose(){
        	this.$modal.hide('edit-profile');
            this.errors='';
        },
        updateProfile(){
           axios.patch('/api/user/'+this.user.id+'/profile',{
               name:this.form.name,
               email:this.form.email,
               company:this.form.company,
               mobile:this.form.mobile,
               bio:this.form.bio,
               address:this.form.address,
               position:this.form.position

           }).then(response=>{
               this.$vToastify.success("Profile Updated Successfully");
               this.user.name=this.form.name;
               this.user.email=this.form.email;
               this.user.company=this.form.company;
               this.user.mobile=this.form.mobile;
               this.user.bio=this.form.bio;
               this.user.address=this.form.address;
               this.user.position=this.form.position;
               this.$modal.hide('edit-profile');
           }).catch(error=>{
                console.log(error.response.data.errors);
            });
        },
             deleteAvatar(){
       swal.fire({
      title: 'Are you sure?',
      text: "You action will delete avatar picture!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
      axios.patch('/api/user/'+this.user.id+'/avatar-delete').then(function(){
        swal.fire(
            'Success!',
            'Profile avatar has been deleted.',
            'success'
          )
        setTimeout(()=>{
             window.location.reload();
        },2000)
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },
  becomeMember(id){
         axios.get('/project/'+id+'/member',{
           }).then(response=>{
              this.$vToastify.success("You have accepted the project invitation");
             setTimeout(()=>{
             window.location.href='/api/projects/'+id;
        },3000)
           }).catch(error=>{
                this.$vToastify.warning("Error! Try Again");
            });
  },
  rejectInvitation(id){
       axios.get('/project/'+id+'/cancel',{
           }).then(response=>{
          this.$vToastify.info("The project request has rejected");
                  $("#project-"+id).fadeOut(300);
           }).catch(error=>{
                this.$vToastify.warning("Error! Try Again");
            });
  },
       deleteProfile(){
       swal.fire({
      title: 'Are you sure?',
      text: "You can't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
      axios.delete('/api/user/'+this.user.id+'/profile').then(function(){
      swal.fire(
          'Success!',
          'Profile has been deleted.',
          'success'
        )
        setTimeout(()=>{
             window.location.href="/";
        },3000)
      }).catch(function(){
          swal.fire("Failed!","There was something wrong.","warning");
      });
  }
    })
  },

    }

}	

</script>
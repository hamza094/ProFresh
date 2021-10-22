f<template>
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
</template>

<script>

export default{
	props:['user'],
	data(){
		return{
			owner:this.user,
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
	methods:{
        modalClose(){
        	this.$modal.hide('edit-profile');
            this.errors='';
        },

        updateProfile(){
           axios.patch('/api/profile/user/'+this.user.id,{
               name:this.form.name,
               email:this.form.email,
               company:this.form.company,
               mobile:this.form.mobile,
               bio:this.form.bio,
               address:this.form.address,
               position:this.form.position,
               password:this.form.password
               
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
    }

}	

</script>
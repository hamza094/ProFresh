<template>
  <modal name="edit-profile"
        height="auto" :scrollable="true" :shiftX=".98" width="38%" class="model-desin" :clickToClose=false>
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

      <form-input label="Name:" v-model="form.name" :error="errors.name" id="name"/>

      <form-input label="Username:" v-model="form.username" :error="errors.username" id="username"/>

      <form-input label="Email:" v-model="form.email" :error="errors.email" id="email"/>

      <form-input label="Company:" v-model="form.company" :error="errors.company" id="company"/>

      <form-input label="Mobile:" v-model="form.mobile" :error="errors.mobile" id="mobile"/>

      <form-input label="Position:" v-model="form.position" :error="errors.position" id="position"/>

      <form-input label="Address:" v-model="form.address" :error="errors.address" id="address"/>

      <div class="form-group">
        <label for="bio" class="label-name">Your Bio:</label>
        <textarea type="text" v-model="form.bio" id="bio" name="bio" class="form-control">{{user.bio}}</textarea>
        <span class="text-danger font-italic" v-if="errors.bio" v-text="errors.bio[0]"></span>
        </div>
        <hr>
        <h3>Update Password:</h3>

        <span v-html="showIcon(showCurrentPassword)" v-on:click="toggleShowCurrentPassword" class="eye-icon float-right"></span>

        <form-input label="Current Password:" v-model="form.current_password" :error="errors.current_password" v-bind:type="currentPasswordFieldType" id="current_password"/>

        <span v-html="showIcon(showPassword)" v-on:click="toggleShowPassword" class="eye-icon float-right"></span>

        <form-input label="New Password:" v-model="form.password" :error="errors.password" type="password" id="password" v-bind:type="passwordFieldType"/>       
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
import FormInput from '../FormInput.vue'
import { mapMutations } from 'vuex';

export default{

  components: {
    FormInput,
  },

	props:['user'],
	data(){
		return{
      showCurrentPassword: false,
      showPassword: false,
			owner:this.user,
            errors:{},
           form:{
              name:'',
              username:'',
              email:'',
              company:'',
              mobile:'',
              position:'',
              address:'',
              current_password:'',
              password:'',
              bio:'',
          },
          originalData:{}
		};
	},
  mounted(){
   this.form.name = this.user.name
    this.form.username = this.user.username
    this.form.email = this.user.email
    this.form.company = this.user.info.company
    this.form.mobile = this.user.info.mobile
    this.form.position = this.user.info.position
    this.form.address = this.user.info.address
    this.form.bio = this.user.info.bio

    this.originalData = _.cloneDeep(this.form)
  },
  computed:{
    currentPasswordFieldType() {
      return this.showCurrentPassword ? 'text' : 'password';
    },
    passwordFieldType() {
      return this.showPassword ? 'text' : 'password';
    },
   showIcon: function() {
    return function(show) {
      return show ? '&#x1F441;' : '&#x1F576;';
    }
  },
  },
	methods:{
    ...mapMutations('profile',['updateUser']),
        modalClose(){
        	this.$modal.hide('edit-profile');
          this.resetForm();
        },

      toggleShowCurrentPassword() {
      this.showCurrentPassword = !this.showCurrentPassword;
      },

      toggleShowPassword() {
      this.showPassword = !this.showPassword;
      },

      updateProfile(){
         if (_.isEqual(this.form, this.originalData)) {
          this.$vToastify.info("Form has not changed");
        return
      }

        axios.patch(`/api/v1/users/${this.user.id}`,this.form)
             .then(response=>{
               this.$vToastify.success("Profile Updated Successfully");
               this.updateUser(response.data.user);
               this.modalClose();
           }).catch(error=>{
                this.errors=error.response.data.errors;
            });
        },
      resetForm() {
      this.form = {
        name: this.user.name,
        username: this.user.username,
        email: this.user.email,
        company: this.user.info.company,
        mobile: this.user.info.mobile,
        position: this.user.info.position,
        address: this.user.info.address,
        current_password: '',
        password: '',
        bio: this.user.info.bio,
      };
      this.errors = {};
    },
    },
}

</script>


<style>
.eye-icon {
  cursor: pointer;
  margin-left: 10px;
}
</style>

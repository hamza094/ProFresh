<template>
	<div class="col-md-2">
	   	<!--<div class="img-avatar" @click="$modal.show('avatar-file')" 
		v-if="authorize('profileOwner',user)">
            <div class="img-avatar_name" v-if="user.avatar_path==null">
                {{user.name.substring(0,1)}}
            </div>
                <div v-else>
                    <img :src="avatar_path" alt="" class="main-profile-img"/>
                </div>
            <div class="img-avatar_overlay">
                <div class="img-avatar_overlay-text">Update</div>
            </div>
            </div>-->

            <!--<div class="img-avatar" v-else>
            <div class="img-avatar_name" v-if="user.avatar_path==null">
                {{user.name.substring(0,1)}}
            </div>
                <div v-else>
                    <img :src="avatar_path" alt="" class="main-profile-img"/>
                </div>
            </div>-->
            
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
</template>

<script>
	import VueCropper from "vue-cropperjs"

export default{
	props:['user'],

		components: {VueCropper},

	data(){
		return{
			imageSrc: "",
            croppedImageSrc: "",
            avatar_path:this.user.avatar_path,
		};
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
    }
}	

</script>
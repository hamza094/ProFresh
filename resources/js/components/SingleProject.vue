<template>
    <div>

        <div class="img-avatar" @click="$modal.show('avatar-file')">
            <div class="img-avatar_name" v-if="project.avatar_path==null">
                {{project.name.substring(0,1)}}
            </div>
                <div v-else>
                    <img :src="avatar_path" alt="" class="main-profile-img"/>
                </div>
            <div class="img-avatar_overlay">
                <div class="img-avatar_overlay-text">Update</div>
            </div>
            </div>
        <div>
            <div class="score-dropdown" @click="isPop = !isPop">
                <!-- trigger -->
                <span v-if="scores <= 49" role="button" class="score-point score-point_cold">{{scores}}</span>
                <span v-else role="button" class="score-point score-point_hot">{{scores}}</span>

                <!-- menu links -->
                <div class="score-dropdown_item" v-show=isPop>
                  <div class="score">
                      <div class="score-content">
                          <p class="score-content_para"><i class="far fa-clock"></i><b>Project</b> since {{project.created_at | timeExactDate}} with current in stage
                          <b v-if="project.stage == 0">Postponed</b>
                          <b v-if ="project.stage == 1">Initial</b>
                          <b v-if="project.stage == 2">Defined</b>
                          <b v-if="project.stage == 3">Designing</b>
                          <b v-if="project.stage == 4">Developing</b>
                          <b v-if="project.stage == 5">Execution</b>
                          <b v-if="project.stage == 6">Closure</b>
                          </p>
                          <div class="score-content_point">
                              <p class="score-content_point-para"><b>Top scoring factors</b></p>
                              <div class="row">
                                  <div class="col-md-3">
                                      <p class="score-content_point-cold">
                    <span v-if="scores <= 49"><span class="score-content_point-cold_point">{{scores}}</span><br><span class="score-content_point-cold_status">Cold</span></span>
                    <span v-else><span  class="score-content_point-hot_point">{{scores}}</span><br><span class="score-content_point-hot_status">Hot</span></span></p>
                                  </div>
                                  <div class="col-md-9">
                                    <div v-if="details == 0" class="">
                                      <h5>The Project score hasn't added</h5>
                                    </div>
                                      <div v-for="details in groupedDetails" class="row">
                                  <div v-for="detail in details" class="col-md-6">
                                    <p class="project-score"><span><i class="fas fa-arrow-up"></i></span> {{detail.message}}</p>
                                  </div>
                                </div>

                                  </div>
                              </div>
                          </div>
                      </div>

                  </div>
                </div>
            </div>

        </div>
        <modal name="avatar-file"
               height="auto">
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
            </div></modal>
    </div>
</template>

<script>
import VueCropper from "vue-cropperjs"

export default {
    props:['project','scores','details'],
    components: {
        VueCropper,
    },
    data() {
        return {
            imageSrc: "",
            croppedImageSrc: "",
            //avatar:this.Project.profile,
            avatar_path:this.project.avatar_path,
            isPop:false,
        }
    },
    watch:{
        isPop(isPop){
            if(isPop){
                document.addEventListener('click',this.emptyIfClickedOutside);
            }
        }
    },
    computed:{
      groupedDetails() {
       return _.chunk(this.details, 2)
    }
    },
    methods: {
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
            Vue.prototype.$projectId=this.project.id;

            this.$vToastify.info({
                title:'Loading...',
                body:'Project Avatar Uploading',
                position:"bottom-left",
                theme:"light",
                duration:3000,
                mode:"loader",
            });


            this.$refs.cropper.getCroppedCanvas().toBlob(function (blob) {
                    var projectp=Vue.prototype.$projectId;
                let formData = new FormData()
                // Append image file
                formData.append("avatar", blob)

                axios.post('/api/project/'+projectp+'/avatar', formData)
                    .then(response=>{
                        window.location.reload();
                    })
                    .catch(function (error) {
                        //Vue.prototype.$notif;
                    })
            })

        },
        emptyIfClickedOutside(event){
            if(!event.target.closest('.score-dropdown')){
                this.isPop=false;
                document.removeEventListener('click',this.emptyIfClickedOutside);
            }
        },

    },

}
</script>

<template>
  <div class="col-md-2">
    <div class="img-avatar" @click="showAvatarModal">
      <div class="img-avatar_name" v-if="!avatar">
        {{ name.substring(0, 1) }}
      </div>
      <div v-else>
        <img :src="avatar" alt="" class="main-profile-img" />
      </div>
      <div class="img-avatar_overlay">
        <div class="img-avatar_overlay-text">Update</div>
      </div>
    </div>

    <modal name="avatar-file" height="auto" :click-to-close="false">
      <div class="p-3 bg-white shadow rounded-lg img_avarar">
        <button class="btn btn-sm float-right" @click="closeAvatarModal">❌</button>
        <input type="file" name="avatar" id="file" accept="image/*" value="Upload Avatar" @change="setImage" />

        <!-- Image previewer -->
        <img :src="imageSrc" width="100" v-if="imageSrc" />

        <!-- Cropper container -->
        <div v-if="imageSrc" class="my-3 d-flex align-items-center justify-content-center mx-auto">
          <vue-cropper class="mr-2 w-50" ref="cropper" :guides="true" :src="imageSrc" :aspect-ratio="0.9"></vue-cropper>

          <!-- Cropped image previewer -->
          <img class="ml-2 w-50 bg-light" :src="croppedImageSrc" />
        </div>

        <button class="btn panel-btn_close" v-if="imageSrc" @click="cropImage">Crop</button>
        <button class="btn panel-btn_save" v-if="croppedImageSrc" @click="uploadImage()">Upload</button>
      </div>
    </modal>
  </div>
</template>

<script>
import VueCropper from 'vue-cropperjs';
import { mapMutations } from 'vuex';

export default {
  components: { VueCropper },
  props: {
    userId: { type: [Number, String], required: true },
    name: { type: String, required: true },
    avatar: { type: String, default: '' },
  },

  data() {
    return {
      imageSrc: '',
      croppedImageSrc: '',
    };
  },
  methods: {
    ...mapMutations('profile', ['updateUserAvatar']),
    showAvatarModal() {
      this.$modal.show('avatar-file');
    },
    closeAvatarModal() {
      this.$modal.hide('avatar-file');
      this.imageSrc = this.avatar;
      this.croppedImageSrc = '';
    },
    setImage(e) {
      const file = e.target.files[0];

      if (!file.type.includes('image/')) {
        alert('Please select an image file');
        return;
      }

      if (typeof FileReader === 'function') {
        const reader = new FileReader();

        reader.onload = (e) => {
          const imageSrc = e && e.target ? e.target.result : null;
          this.updateImage(imageSrc);
        };

        reader.onerror = (e) => {
          const msg = e && e.target && e.target.error ? e.target.error.message : 'Error reading file';
          this.$vToastify.error(msg);
        };

        reader.readAsDataURL(file);
      } else {
        alert('Sorry, FileReader API not supported');
      }
    },

    updateImage(imageSrc) {
      this.imageSrc = imageSrc;
      if (this.$refs.cropper) {
        this.$refs.cropper.replace(imageSrc);
      }
    },

    cropImage() {
      // Get image data for post processing, e.g. upload or setting image src
      try {
        this.croppedImageSrc = this.$refs.cropper.getCroppedCanvas().toDataURL();
      } catch (error) {
        this.$vToastify.error(error?.message || 'Failed to crop image');
        // Optional: log the actual error for debugging
        // console.error(error);
      }
    },

    async uploadImage() {
      this.$vToastify.loader('Please Wait Avatar Uploading');

      const canvas = this.$refs.cropper.getCroppedCanvas();
      const blob = await new Promise((resolve) => canvas.toBlob(resolve));

      let formData = new FormData();
      formData.append('avatar', blob);

      axios
        .post('/api/v1/users/' + this.userId + '/avatar', formData)
        .then((response) => {
          this.updateUserAvatar(response.data.avatar);
          this.closeAvatarModal();
          this.$vToastify.success('Avatar Updated Successfully');
        })
        .catch((error) => {
          const msg = error?.response?.data?.message || error?.message || 'Failed To Update Avatar';
          this.$vToastify.warning(msg);
        })
        .finally(() => {
          this.$vToastify.stopLoader();
        });
    },
  },
};
</script>

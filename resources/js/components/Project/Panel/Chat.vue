<template>

<div>

<div class="card chat-card mb-5">

<div class="card-header text-white bg-primary" id="accordion">

  <span>
    <i class="fas fa-comment-alt"></i>
     Group chat  
     <span v-if="conversations" class="badge badge-secondary">
     {{conversations.length}}
   </span> messages
   </span> 

    <a type="button" class="btn btn-default btn-xs float-right" data-toggle="collapse" :href="'#collapseOne-' + slug">
     <i class="fas fa-angle-down"></i>
    </a>     
    </div>

  <div class="collapse" :id="'collapseOne-' + slug">
    <div class="card-body chat-panel">

      <!-- Start of Chat Message -->

      <ul class="chat">
      <li v-for="conversation in conversations" :key="conversation.id">
      <div class="chat-body clearfix">
      <div class="header">

      <router-link :to="'/user/'+conversation.user[0].name +'/profile'">
        <img :src="conversation.user[0].avatar_path" alt="User Avatar" class="chat-user_image"/>
      </router-link>

      <strong class="primary-font">
      {{ conversation.user[0].name }}</strong>

    </div>

        <p v-if="conversation.message" class="mt-2">
          <span class="chat-message" v-html="conversation.message">
         </span>
        </p>

        <p v-if="conversation.file" class="mt-2">
          <span v-if="conversation.file.includes('.PNG') || conversation.file.includes('.JPEG') || conversation.file.includes('.JPG')"><img
          :src="conversation.file" class="chat-image" alt=""></span>

          <span v-else>
            <a :href="conversation.file" target="_blank" >{{conversation.file}}</a>
          </span>
        </p>

        <br>
          <span class="float-right chat-time">
            <i>{{conversation.created_at}}</i>
          </span>

          <button v-if="conversation.user[0].id == user.id" class="btn btn-link btn-sm" @click.prevent="deleteConversation(conversation.id)">Delete</button>

          </div>
          </li>
          <span v-show="typing" class="help-block" style="font-style: italic;">
                @{{ user.name }} is typing...
          </span>
          </ul>

          <!-- Next Section -->

            </div>

            <div class="card-footer gioj">
          <div class="chat-floating">

        <Picker :data="emojiIndex" v-if="emojiModal" set="twitter" @select="showEmoji" title="Pick your emoji…"
        :style="{ position: 'absolute', bottom: '27px' }"/>

    </div>

       <Mentionable :keys="['@']" :items="items" offset="6"
        insert-space @open="onOpen" @apply="onApply">

        <textarea class="form-control mb-2" placeholder="Type your message here..." v-model="message" autofocus
        @keydown="isTyping" row="3">
        </textarea>

    <template #no-result>
      <div class="dim">
        No result
      </div>
    </template>

    <template #item-@="{ item }">
      <div class="user">
         <img :src="item.avatar_path" alt="User Avatar" class="mention-user"/> 
         <span class="dim">
          {{ item.name }}
        </span> 
        <span class="dim">
          ({{ item.username }})
        </span>
      </div>
    </template>

  </Mentionable>
     <p> <span class="input-group-btn">
          <i class="far fa-grin chat-emotion" @click="chatEmotion()"></i>

    <button class="btn btn-primary btn-sm" id="btn-chat" @click.prevent="store()">Send</button>       
   </span>
       <input type="file" name="file" ref="file" class="inputfile btn btn-sm mt-2" value="upload file" @change="fileUpload()" accept="image/jpeg,image/png,application/pdf"/></p>
   </div>
   </div>
   </div>
</div>
</template>
<style>
.mention-item {
  padding: 4px 10px;
  border-radius: 4px;
}

.mention-selected {
  background: rgb(192, 250, 153);
}
</style>
<script>

import data from "emoji-mart-vue-fast/data/all.json";
import { Mentionable } from 'vue-mention'
import { Picker, EmojiIndex } from "emoji-mart-vue-fast";

let emojiIndex = new EmojiIndex(data);

export default {
  components:{Picker,Mentionable},
    props:['conversations','slug','users'],
    data() {
      return {
      emojiIndex: emojiIndex,
      message: '',
      user:this.$store.state.currentUser.user,
      typing: false,
      emojiModal:false,
      file:'',
      items: [],
    };
    },

  methods: {
    async   onOpen (key) {
      this.items = key === '@' ? this.users : '';
    },

     async onApply (item, key) {
       this.message=this.message+'@'+item.username;
        this.message=this.message.replace('@undefined','');
       
    },
     showEmoji(emoji) {
       if(!emoji){
          return false;
        }
        if(!this.message){
          this.message=emoji.native;
        }else{
          this.message=this.message + emoji.native;
        }
    },

  fileUpload(){
    this.file=this.$refs.file.files[0];

    let formData = new FormData()
    formData.append("file", this.file);

    this.$vToastify.info('Be patient file uploading');

    axios.post('/api/v1/projects/'+this.slug+'/conversations',formData).then(response=>{
          this.$vToastify.success("File Uploaded");

      }).catch(function (error) {
        this.$vToastify.warning("Error! Try Again");
      })
    },

  store() {
    axios.post('/api/v1/projects/'+this.slug+'/conversations', {message: this.message})
    .then((response) => {
    this.message = '';
    }).catch(error=>{
      this.$vToastify.warning("Error! Try Again");
    });
    },
    
    deleteConversation(id){
      axios.delete('/api/v1/projects/'+this.slug+'/conversations/'+id)
      .then(response=>{
         this.$vToastify.info("conversation deleted");
      }).catch(error=>{
        this.$vToastify.warning("Task deletion failed");
      })
    },


  isTyping() {
  let channel = Echo.private('chat');

  let _this = this;

  setTimeout(function() {
    channel.whisper('typing', {
      user:_this.$store.state.currentUser.user,
        typing: true
    });
  }, 300);
  },

  chatEmotion(){
    this.emojiModal= !this.emojiModal;
  },
  },

    created(){
    let _this = this;

  Echo.private('chat')
    .listenForWhisper('typing', (e) => {
      this.user = e.user;
      this.typing = e.typing;

      // remove is typing indicator after 0.9s
      setTimeout(function() {
        _this.typing = false
      }, 900);
    });
  },
}
</script> 
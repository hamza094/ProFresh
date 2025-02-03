<template>

<div>

 <p><b><i>Start Group chat with project Members</i></b></p>

<!-- <SubscriptionCheck> -->
<div class="card chat-card mb-5">
<div class="card-header d-flex align-items-center justify-content-between bg-primary text-white" id="accordion">

  <div class="d-flex align-items-center">
      <i class="fas fa-comment-alt mr-2"></i>
      <span>Group Chat</span>
      <span v-if="conversations.length" class="badge badge-light ml-2">{{ conversations.length }}</span>
      <span class="ml-1">messages</span>
    </div> 

    <a type="button" class="btn btn-default btn-xs float-right" data-toggle="collapse" :href="'#collapseOne-' + slug">
     <i class="fas fa-angle-down"></i>
    </a>   

    </div>

  <div class="collapse" :id="'collapseOne-' + slug">
    <div class="card-body chat-panel">

      <!-- Chat Message -->

      <ul class="chat">
      <li v-for="(conversation,index) in conversations.data" :key="index">
      <div class="chat-body clearfix">
      <div class="header">

      <router-link :to="'/user/'+conversation.user.name +'/profile'">
        <img v-if="conversation.user.avatar" :src="conversation.user.avatar" alt="User Avatar" class="chat-user_image"/>
      </router-link>

      <strong class="primary-font">
      {{ conversation.user.name }}</strong>

    </div>
        <p v-if="conversation.message" class="mt-2">
          <span class="chat-message" v-html="conversation.message">
         </span>
        </p>

        <p v-if="conversation.file" class="mt-2">
          <span v-if="isImage(conversation.file)"><img
          :src="conversation.file" class="chat-image" alt=""></span>

          <span v-else>
            <a :href="conversation.file" target="_blank" >{{conversation.file}}</a>
          </span>
        </p>

        <br>
          <span class="float-right chat-time">
            <i>{{conversation.created_at}}</i>
          </span>

          <button v-if="auth.id == conversation.user.id" class="btn btn-link btn-sm" @click.prevent="deleteConversation(conversation.id,index)">Delete</button>

          <button v-else class="btn btn-link btn-sm disabled">Delete</button>

          </div>
          </li>
          <span v-if="typing" class="help-block" style="font-style: italic;">
              💬  @{{ user.name }} is typing...
          </span>
          <span v-else class="help-block" style="font-style: italic;">
                💬
          </span>
          </ul>

          <!-- Chat Footer -->

            </div>

            <div class="card-footer gioj">
              
          <div class="chat-floating">
        <transition name="emoji-slide" mode="out-in">
      <Picker
        v-if="emojiModal"
        :data="emojiIndex"
        set="twitter"
        @select="showEmoji"
        title="Pick your emoji…"
        class="emoji-modal"
        :showPreview="false"
      />
    </transition>
    </div>

      <!-- Chat with mentionable user functionality -->   

       <Mentionable :keys="['@']" :items="items" offset="6"
        insert-space @open="onOpen" @apply="onApply">

        <div class="position-relative w-100">
        <textarea 
        class="form-control mb-2" 
        placeholder="Type your message here..." 
        v-model="message" 
        autofocus 
        @keypress.enter.exact.prevent="send()"
        @keydown="isTyping" 
        row="1">
        </textarea>

      <i class="far fa-grin chat-emotion position-absolute" @click="toggleEmojiModal">
      </i>
    </div>
        
<div class="d-flex align-items-center">
    <!-- Attach File Button -->
    <button @click="openFilePicker" class="btn btn-light">
        <i class="fas fa-paperclip"></i> Attach File
    </button>

    <!-- Show Selected File Name with Delete Option -->
    <div v-if="file" class="ml-2 d-flex align-items-center">
        <i class="fas fa-file-alt mr-1"></i> 
        <span class="file-name">{{ fileName }}</span>
        <button @click="removeFile" class="btn btn-sm text-danger p-0 ml-2 file-close-btn">✖</button>
    </div>

    <!-- Hidden File Input -->
    <input type="file" ref="fileInput" class="d-none" @change="fileUpload">
</div>

    <template #no-result>
      <div class="dim">
        No result
      </div>
    </template>

    <template #item-@="{ item }">
      <div class="user">
         <img :src="item.avatar" alt="User Avatar" class="mention-user"/> 
         <span class="dim">
          {{ item.name }}
        </span> 
        <span class="dim">
          ({{ item.username }})
        </span>
      </div>
    </template>
  </Mentionable>
    <p> 
    <button 
    class="btn btn-primary btn-sm float-right mb-2" 
    id="btn-chat" 
    @click.prevent="send()">Send</button>
    </p>

   </div>
   </div>
   </div>
        <!-- </SubscriptionCheck>-->
    <vue-progress-bar></vue-progress-bar>
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
import SubscriptionCheck from '../../SubscriptionChecker.vue';

export default {
  components:{Picker,Mentionable,SubscriptionCheck},
    props:['slug','users','auth'],
    data() {
      return {
      emojiIndex: new EmojiIndex(data),
      message: '',
      typing: false,
      emojiModal:false,
      user:this.auth,
      fileName: '',
      file:'',
      items: [],
      conversations:[],
    };
    },

  methods: {
    isImage(file) {
    return /\.(png|jpg|jpeg)$/i.test(file);
  },
    async   onOpen (key) {
      this.items = key === '@' ? this.users : '';
    },

     async onApply (item, key) {
       this.message=this.message+'@'+item.username;
        this.message=this.message.replace('@undefined','');
       
    },
     showEmoji(emoji) {
      if(!emoji) return;
       this.message += emoji.native;
    },

    openFilePicker() {
        this.$refs.fileInput.click(); // Open file picker when button is clicked
    },

    fileUpload(event) {
        this.file = event.target.files[0];
        if (this.file) {
            this.fileName = this.file.name;
        }
    },

    removeFile() {
        this.file = null;
        this.fileName = "";
        this.$refs.fileInput.value = ""; // Clear input field
    },

  send() {
    if(this.message.length === 0 && !this.file ){
      this.$vToastify.warning("Please enter a message or upload a file.");
      return;
    }
    
    let formData = new FormData();
  formData.append("message", this.message || "");
  if (this.file) {
    formData.append("file", this.file);
  }

    axios.post('/api/v1/projects/'+this.slug+'/conversations', formData,{ useProgress: true })
    .then((response) => {
      this.message = '';
      this.file = null;
      //this.listenForNewMessage();
    }).catch(error=>{
    this.$vToastify.error("Failed to send message.");
    });
  
    },
    
    deleteConversation(id,index){
      axios.delete('/api/v1/projects/'+this.slug+'/conversations/'+id,{ useProgress: true })
      .then(response=>{
         this.$vToastify.info("Conversation deleted sucessfully");
         //this.listenToDeleteConversation();
      }).catch(error=>{
        this.$vToastify.warning("Conversation deletion failed");
      })
    },

  isTyping() {
  Echo.private(`typing.${this.slug}`).whisper('typing-indicator', {
    user: this.auth,
    typing: true,
  });

  if (this.typingTimeout) clearTimeout(this.typingTimeout);
  this.typingTimeout = setTimeout(() => {
    this.typing = false;
  }, 1000);
},

  toggleEmojiModal() {
      this.emojiModal = !this.emojiModal;
    },

  loadConversations() {
    return axios
        .get('/api/v1/projects/'+this.slug+`/conversations`)
        .then(response => {
            this.conversations = response.data;
        })
        .catch(error => {
          console.log(error);
            this.conversations=[];
        });
},
    listenForNewMessage() {
      Echo.private(`conversations.${this.slug}`)
        .listen('NewMessage', (e) => {
          if (!this.conversations.find((conv) => conv.id === e.id)) {
          this.conversations.push(e);
        }
      });
    },

    listenToDeleteConversation(){
      Echo.private(`deleteConversation.${this.slug}`)
        .listen('DeleteConversation', (e) => {
        this.conversations.splice(this.conversations.indexOf(e),1);
        this.$vToastify.success("conversation deleted");
      });
    },
  },

    created(){

    this.loadConversations();
    let _this = this;

  Echo.private('typing.'+this.getProjectSlug())
    .listenForWhisper('typing-indicator', (e) => {
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
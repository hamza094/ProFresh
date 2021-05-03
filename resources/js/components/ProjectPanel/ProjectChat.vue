<template>

<div>
<div class="card chat-card">
    <div class="card-header text-white bg-primary" id="accordion">

      <span><i class="fas fa-comment-alt"></i> {{ projectgroup.name }} with {{cons_count}} messages</span> 

    <a type="button" class="btn btn-default btn-xs float-right" data-toggle="collapse" :href="'#collapseOne-' + projectgroup.id">
        <i class="fas fa-angle-down"></i>
    </a>     
        </div>

            <div class="collapse" :id="'collapseOne-' + projectgroup.id">
              <div class="card-body chat-panel">

               <ul class="chat">
                        <li v-for="conversation in conversations">
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <img :src="conversation.user.avatar_path" alt="User Avatar" class="chat-user_image" v-if="conversation.user.avatar_path!=null" />

                                     <img v-else src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvsQZEtAw99ePVsNhLCexVsSKct6D13NluBQ&usqp=CAU" alt="" class="chat-user_image">
                                    <strong class="primary-font">{{ conversation.user.name }}</strong>
                                </div>

                                <p v-if="conversation.message" class="mt-2">
                                   <span class="chat-message"> {{ conversation.message }} </span>
                                   <br>
                                <span class="float-right chat-time"><i>{{conversation.created_at | timeExactDate}}</i></span>
                                </p>

                                 <p v-if="conversation.file" class="mt-2">
                                    <span v-if="conversation.file.includes('.png') || conversation.file.includes('.jpeg') || conversation.file.includes('.jpg') || conversation.file.includes('.gif')"><img
                                    :src="conversation.file" class="chat-image" alt=""></span>
                                    <span v-else><a :href="conversation.file" target="_blank" >{{conversation.file}}</a></span>
                                    <br>
                                <span class="float-right chat-time"><i><b>{{conversation.created_at | timeExactDate}}</b></i></span>
                                </p>
                            </div>
                        </li>
                           <span v-show="typing" class="help-block" style="font-style: italic;">
                            @{{ user.name }} is typing...
                        </span>
                    </ul>
              </div>
              <div class="card-footer gioj">
          <div class="chat-floating">
          <picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" />
           </div>
               <div class="input-group">
                        <input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here..." v-model="message" @keyup.enter="store()"
                        @keydown="isTyping"  autofocus />

                        <span class="input-group-btn">
                            <i class="far fa-grin chat-emotion" @click="chatEmotion()"></i>

      <file-upload 
      v-bind:post-action="'/api/project/'+this.project.id+'/conversations'"
    ref="upload"
    @input-file="$refs.upload.active = true"
    :headers="{'X-CSRF-TOKEN': this.token}">
  <button class="btn btn-primary btn-sm"> <i class="fas fa-upload"></i> </button>
  </file-upload>

<button class="btn btn-primary btn-sm" id="btn-chat" @click.prevent="store()">
  Send</button>        
</span>
</div>
</div>
</div>
</div>

    </div>
</template>

<script>

import { Picker } from 'emoji-mart-vue'

export default {
  components:{Picker},
    props:['project','projectgroup','cons'],
    data() {
      return {
     group_id:this.projectgroup.id,
      conversations: {},
      message: '',
      user:window.App.user,
      token:window.App.csrfToken,
      typing: false,
      typing: false,
      emoStatus:false,
      cons_count:this.cons
    };
    },

  methods: {
   onInput(e){
        if(!e){
          return false;
        }
        if(!this.message){
          this.message=e.native;
        }else{
          this.message=this.message + e.native;
        }
      },

  store() {
    axios.post('/api/project/'+this.project.id+'/conversations', {message: this.message})
    .then((response) => {
    this.message = '';
    this.cons_count++;
    this.getConversation();
    }).catch(error=>{
      this.$vToastify.warning("Error! Try Again");
    });
    },

  getConversation(){
      axios.get('/api/project/'+this.project.id+'/conversation')
                  .then(({data})=>(this.conversations=data)); 
    },

    listenForNewMessage() {
    Echo.private('groups.' + this.projectgroup.id)
      .listen('NewMessage', (e) => {
        this.conversations.push(e);

      });
  },

  isTyping() {
  let channel = Echo.private('chat');

  setTimeout(function() {
    channel.whisper('typing', {
      user: window.App.user,
        typing: true
    });
  }, 300);
  },

  chatEmotion(){
    this.emoStatus= !this.emoStatus;
  },
  },

    created(){
    this.getConversation();
    this.listenForNewMessage();

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
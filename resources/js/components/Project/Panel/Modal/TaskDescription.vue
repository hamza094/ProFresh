<template>
 <div class="task-description">
                 <p class="task-description_container">
                  <span class="task-description_heading">Description:</span>
                  <span class="text-danger font-italic" v-if="errors?.description" v-text="errors?.description?.[0]"></span>
                </p>

                <div v-if="edit == task.id">
              
                <vue-editor name="description" 
                v-model="form.description" :editorToolbar="customToolbar"></vue-editor>

            <span class="btn btn-link btn-sm" @click="updateDescription(task.id,task)">Update</span>

           <span class="btn btn-link btn-sm" @click="closeDescriptionForm(task.id,task)">Cancel</span>
          </span>
          
      </div>
            <div v-else>

              <p v-if="task.description" class="task-description_content-link" @click="openDescriptionForm(task.id,task)" v-html="task.description"></p>

              <div v-else="task.description">
              <p class="task-description_content">Sorry! currently no task description present. <a class="task-description_content-link" @click="openDescriptionForm(task.id,task)"> Click here to add description</a>
              </p>

            </div>
            </div>  
              </div>
</template>

<script>
  import { VueEditor } from "vue2-editor";
  import { mapMutations, mapActions, mapState } from 'vuex';
  import {url,ErrorHandling} from '../../../../utils/TaskUtils';
export default {
      props:['task','slug','errors'],
  components: {VueEditor},
  data() {
    return {
    edit:0,
      customToolbar: [
        ["bold", "italic", "underline"],
        [{ list: "ordered" }, { list: "bullet" }],
        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
        ['blockquote'],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        ['link', 'unlink'],
        ]
    };
  },
     computed: {
    ...mapState('SingleTask',['form']),
  },
  methods: {
      ...mapMutations('SingleTask',['setErrors','updateTaskDescription']),

    updateDescription(id,task){
      if (this.form.description === this.task.description) {
         return  this.$vToastify.warning('No changes made.');
      }
     axios.put(url(this.slug, id),{description: this.form.description },{ useProgress: true })
    .then(response => {
      this.$vToastify.success(response.data.message);
        this.edit = false;
        this.setErrors([]);
        this.updateTaskDescription(response.data.task.description);
    })
    .catch(error => {
      ErrorHandling(this,error);
    });
   }, 

    closeDescriptionForm(id,task){
      this.edit=false;
      this.form.description=task.description;
    },

    openDescriptionForm(id,task){
      this.edit = id;
      this.form.description=task.description;
    },
  
  },
};
</script>


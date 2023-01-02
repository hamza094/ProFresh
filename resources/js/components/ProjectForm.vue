<template>
    <div class="panel">
       <div class="panel-top">
          <div class="panel-top_content">
            <span class="panel-heading">Add New Project</span>
           <span class="panel-exit float-right" role="button" @click.prevent="closePanel">x</span>
          </div>
       </div>
        <div class="panel-form">
            <form action="">
                <div class="panel-top_content">

                <div class="form-group">
                    <label for="name" class="label-name">Name:*</label>
                    <input type="text" id="lastname" class="form-control" v-model="form.name" name="name" placeholder="Enter value">
                    <span class="text-danger font-italic" v-if="errors.name" v-text="errors.name[0]"></span>
                </div>

                <div class="form-group">
                    <label for="about" class="label-name">About:*</label>
                    <textarea id="about" class="form-control" name="about" v-model="form.about" placeholder="Enter project about" rows="5"></textarea>
                    <span class="text-danger font-italic" v-if="errors.about" v-text="errors.about[0]"></span>
                </div>

                <div class="form-group">
                    <label for="Tasks" class="label-name">Select Stage:*</label>
                    <br>
                    <div v-for="stage in this.stages" class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="stage_id" :value="stage.id" v-model="form.stage_id" :key="stage.id">
                    <label class="form-check-label" for="inlineRadio1">{{stage.name}}</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Tasks" class="label-name">Need Some Tasks?:
                    <span class="text-danger font-italic" v-if="taskError"> {{this.taskError}}</span>
                    </label>
                    <input type="text" class="form-control model-input mb-2" placeholder="Task..." name="task" v-for="task in form.tasks" v-model="task.body"> 
                    <button type="btn" class="btn btn-primary btn-sm" v-if="form.tasks && form.tasks.length < 3" @click.prevent="addTask"><i class="fas fa-plus-circle"></i> Add new Task Field
                    </button>
                     <button v-if="form.tasks && form.tasks.length > 1" type="btn" class="btn btn-danger btn-sm" @click.prevent="removeTask"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove Task Field
                    </button>
                </div>

                <div class="form-group">
                    <label for="note" class="label-name">Note:</label>
                    <textarea id="note" class="form-control" name="note" v-model="form.note" placeholder="Write project about" rows="4"></textarea>
                    <span class="text-danger font-italic" v-if="errors.note" v-text="errors.note[0]"></span>
                </div>                    

                </div>

                    <div class="panel-bottom">
                        <div class="panel-top_content float-right">
                        <button class="btn panel-btn_close" @click.prevent="closePanel">Cancel</button>
                            <button class="btn panel-btn_save" @click.prevent="projectSubmit">Save</button>
                        </div>
                    </div>

                </form>
        </div>
    </div>
</template>
<script>
export default{
    data(){
        return{
           form:{
            stage_id:1,
            tasks:[
             {body:''}
            ]
           },
           stages:[],
            errors:{},
            taskError:'',
        };
    },
    methods:{
        closePanel() {
            this.$emit("closePanel", {});
            this.errors={};
            this.taskError='';
            this.form={};
        },
        loadStages(){
                 axios.get('/api/v1/stages').
                 then(response=>{
                    this.stages=response.data;
                 }).catch(error=>{
                    console.log(error.response.data.errors);
                 });
            },
        addTask(){
          this.form.tasks.push({body:''});
      },
      removeTask(){
        this.form.tasks.pop({body:''});
      },   
        projectSubmit(){
         axios.post('/api/v1/projects',this.form)
            .then(response=>{
             this.$vToastify.success("New project created");
               this.form="";
                this.closePanel();
                setTimeout(()=>{
                this.$router.push('/projects/'+response.data.slug);
                },3000)

            }).catch(error=>{
                if(error.response.data.message.includes('The tasks.')){
                    this.taskError=error.response.data.message;
                    this.errors='';
                }else{
                    this.errors=error.response.data.errors;
                    this.taskError='';
                }
         });
        }
    },
    mounted(){
      this.loadStages();
    },
}
</script>

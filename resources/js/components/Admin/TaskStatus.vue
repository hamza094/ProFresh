<template>
  <div>
     <button class="btn btn-outline-dark w-100 btn-sm" @click.pervent="modalStatus()">View</button>
     
      <modal name="status-modal" height="auto" :scrollable="true"
      width="40%" :clickToClose=false>
    <div class="container m-2">
    <h3>Task Statuses Panel</h3>
    <div class="mb-2 mt-3">
    <button v-if="!showForm" @click="showForm = true" class="btn btn-dark btn-sm">+</button>
 <div class="row" v-if="showForm">
  <div class="col-md-6">
    <div class="form-group">
      <label for="input1" class="col-form-label">Label:</label>
      <input type="text" class="form-control" id="input1" v-model="form.label">
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label for="input2" class="col-form-label">Color:</label>
      <input type="text" class="form-control" id="input2" v-model="form.color">
    </div>
  </div>
  <div class="col-md-2">
<button class="btn btn-sm btn-primary" @click.pervent="addStatus">Add Status</button>
</div>
<div class="col-md-2">
  <button class="btn btn-sm btn-secondary" @click.pervent="closeForm">x</button>
</div>
</div>
    </div>
            <div class="card">
    <div class="list-group list-group-flush">
      <a class="list-group-item list-group-item-action mb-2" v-for="status in statuses" :key="status.id">
        <span v-if="edit && editStatusId === status.id">
   <div class="row">
  <div class="col-md-6">
    <label for="labelInput" class="col-form-label">Label:</label>
    <input type="text" class="form-control mb-2" v-model="form.updateLabel" id="labelInput">
  </div>
  <div class="col-md-6">
    <label for="colorInput" class="col-form-label">Color:</label>
    <input type="text" class="form-control mb-2" v-model="form.updateColor" id="colorInput">
  </div>
</div>
       <button  class="btn btn-success btn-sm float-right ml-1" @click="updateStatus(status)"> Update </button>
        <button class="btn btn-secondary btn-sm float-right" @click="cancelEdit"> Cancel </button>
    </span>
    <span v-else>{{status.label}} <span class="status-color" :style="{ backgroundColor: status.color }"></span>
       <span class="float-right">
       <button class="btn btn-link btn-sm" @click.pervent="editStatus(status)">Edit</button>
        <button class="btn btn-sm btn-danger" @click.pervent="deleteStatus(status.id)">x</button>
     </span>
      </span>
    </a>
    </div>
    </div>
          <button class="btn btn-dark float-right mb-2 mt-3" @click="modalExit()">Modal Close</button>
        </div>
    </modal>
     
  </div>
</template>

<script>
  import { mapState, mapMutations, mapActions } from 'vuex';

export default {
  data() {
    return {
      edit: false,
      editStatusId: null,
      showForm: false,
      form:{
        label:'',
        color:'',
        updateLabel:'',
        updateColor:'',
      }
    };
  },
  computed:{
    ...mapState('status',['statuses']),
  },
  methods: {
    ...mapActions('status',['loadStatuses','addNewStatus']),
    ...mapMutations('status',['statusUpdate','statusDelete']),
   modalStatus(){
      this.$modal.show('status-modal');
   },
   modalExit(){
      this.$modal.hide('status-modal');
      this.closeForm();
      this.cancelEdit();
   },
   closeForm(){
    this.showForm=false;
    this.form.label='';
    this.form.color='';
   },
    editStatus(status) {
      this.edit = true;
      this.editStatusId = status.id;
      this.form.updateLabel=status.label;
      this.form.updateColor=status.color;      
    },

    cancelEdit() {
      this.edit = false;
      this.editStatusId = null;
    },

 async addStatus() {
      try {
        const response = await this.addNewStatus({ 
          label: this.form.label,
          color:this.form.color
        });
        this.$vToastify.success('Status added successfully');
        this.form.label = '';
        this.form.color='';
        this.showForm = false;
      } catch (error) {
         if (error.response) {
          this.$vToastify.error(error.response.data.message);
        } else {
          this.$vToastify.error('Error! Try again later');
        }
        this.form.label = '';
        this.form.color='';
        this.showForm = false;
      }
    },

   updateStatus(status){
    axios.put('/api/v1/admin/statuses/'+status.id,{
      label: this.form.updateLabel,
      color: this.form.updateColor 
    })
    .then(response => {
      this.statusUpdate(response.data.status);
      this.edit = false;
      this.editStatusId = null;
      this.$vToastify.success(response.data.message);
    })
    .catch(error => {
      this.$vToastify.error('Failed to update! Try again Later');
    });
   },
   deleteStatus(statusId){
    axios.delete('/api/v1/admin/statuses/'+statusId,{
      label: this.form.label,
    })
    .then(response => {
      this.statusDelete(statusId);
      this.$vToastify.success(response.data.success);
    })
    .catch(error => {
      this.$vToastify.error('Failed to delete! Try again Later');
    });
   },
  },
  mounted(){
    this.loadStatuses();
  }
};
</script>


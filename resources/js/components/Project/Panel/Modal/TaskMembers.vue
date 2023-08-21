<template>
	    <div class="member-dropdown_item" v-show=memberPop>
                    <p class="text-center m-1"><small><b>Assign Task To Member</b></small></p>

                     <input type="text" placeholder="Search Members" class="form-control" v-model="form.search" name="member" autocomplete="off">

                       <div v-if="hasError('members')">
    <span class="text-danger font-italic" v-for="error in getErrors('members')" :key="error">*{{ error }}</span>
  </div>

  <div v-if="hasError('members.0')">
    <span class="text-danger font-italic" v-for="error in getErrors('members.0')" :key="error">*{{ error }}</span>
  </div>

                <div class="member-list" v-if="searchResults.length > 0 && form.search">        
                <div v-for="member in searchResults" :key="member.id"
               class="member-list_items">
              <div @click.prevent="addMember(member,member.id)">{{member.name}} ({{member.username}})
              </div>
              </div> 
               </div>

                  <button class=" mt-2 btn btn-sm btn-primary float-right" @click="assignMembers(task.id)">Assign</button>

                    <div v-if="taskMembers.length > 0" class="mt-3" style="height:70px;width:150px; overflow-y:scroll;">

                      <div v-for="member in taskMembers">
                        <span>{{member.username}} <span @click.prevent="removeMember(member,member.id)"><i class="fas fa-minus-circle"></i></span> </span>
                      </div>
                    </div>
                  </div>
</template>


<script type="text/javascript">
export default {
  data() {
    return {
    searchResults:"",
    taskMembers: [], 
    form:{
    	search:'',
    }
    };
  },
    watch:{
      'form.search': debounce(function(newSearch) {
      this.performSearch(newSearch);
    }, 500),
    },
  methods: {
  	  performSearch(searchTerm) {
    axios.get(`/api/v1/projects/${this.slug}/member/search`, {
        params: { search: this.form.search}
    })
    .then(response => {
        this.searchResults=response.data;
    })
    .catch(error => {
        console.log(error);
    });
},
 addMember(member,id){
  this.taskMembers.push(member);
  this.searchResults=[];
  this.form.search='';
},


removeMember(member,id){
  this.taskMembers = this.taskMembers.filter((m) => m !== member);
},

    assignMembers(taskId){
      if(!this.taskMembers.length){
        return this.$vToastify.info('no member is selected to assign task')
      }

      const memberIds = this.taskMembers.map(member => member.id);

        axios.patch(url(this.slug, taskId)+'members',{
              members:memberIds,
          }).then(response=>{
            this.taskMembers=[];
            this.task.members=response.data.taskMembers;
            this.errors='';
            this.$vToastify.success(response.data.message);
          }).catch(error=>{
             if (error.response.status === 422) {
            this.errors = error.response.data.errors;
            }
          });
    },

    getErrors(key) {
      if (this.hasError(key)) {
        return this.errors[key];
      }
      return [];
    },
    hasError(key) {
      return this.errors.hasOwnProperty(key);
    },
  },
};
</script>
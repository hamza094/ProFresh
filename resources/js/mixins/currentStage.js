export default{
// mixin for detect project current stage
    methods:{
      currentStage($stage,$completed){
      let stagename='';
      if($stage){
        stagename=$stage.name;
      }
      if(!$stage){
        $completed ? stagename="Completed" : stagename="Postponed"
      }
      return stagename;
    },
    }
}

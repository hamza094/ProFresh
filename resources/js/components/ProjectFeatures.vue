<template>
    <div>
        <div class="img-avatar">
            <div class="img-avatar_name">
                {{project.name.substring(0,1)}}
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
    </div>
</template>

<script>
export default {
    props:['project','scores','details'],
    data() {
        return {
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
        emptyIfClickedOutside(event){
            if(!event.target.closest('.score-dropdown')){
                this.isPop=false;
                document.removeEventListener('click',this.emptyIfClickedOutside);
            }
        },

    },

}
</script>

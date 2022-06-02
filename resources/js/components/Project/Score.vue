<template>
    <div>
        <div class="img-avatar">
            <div class="img-avatar_name">
                  {{(projectName || '').substring(0,1)}}
            </div>
            </div>
        <div>
            <div class="score-dropdown" @click="isPop = !isPop">
                <!-- trigger -->
                <span role="button" class="score-point" :class="'score-point_'+status">{{points}}</span>

                <!-- menu links -->
                <div class="score-dropdown_item" v-show=isPop>
                  <div class="score">
                      <div class="score-content">
                          <p class="score-content_para"><i class="far fa-clock"></i>The project started {{start}}. Currently in its
                            <b v-text="stagename()"></b> stage
                          </p>
                          <div class="score-content_point">
                              <p class="score-content_point-para"><b>Top scoring factors</b></p>
                              <div class="row">
                                  <div class="col-md-3">
                                      <p class="score-content_point-cold">
                    <span><span  :class="'score-content_point-'+status+'_point'">{{points}}</span><br><span :class="'score-content_point-'+status+'_status'">{{status}}</span></span>
                  </p>
                                  </div>
                                  <div class="col-md-9">
                                    <div v-if="scores_detail == 0" class="">
                                      <h5>The Project score hasn't added</h5>
                                    </div>
                                      <div v-for="scores_detail in groupedDetails">
                                  <div v-for="detail in scores_detail">
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
    props:['projectName','points','scores_detail','start','stage','completed','status'],
    data() {
        return {
            isPop:false,
            loading: false,
        }
    },
    watch:{
        isPop(isPop){
            if(isPop){
                document.addEventListener('click',this.emptyIfClickedOutside);
            }
        }
    },
    mounted(){
      this.loading=true;
    },
    computed:{
      groupedDetails() {
       return _.chunk(this.scores_detail, 2)
    },
    },
    methods: {
        emptyIfClickedOutside(event){
            if(!event.target.closest('.score-dropdown')){
                this.isPop=false;
                document.removeEventListener('click',this.emptyIfClickedOutside);
            }
        },
        stagename(){
        return this.currentStage(this.stage,this.completed);
     },
    },
}
</script>

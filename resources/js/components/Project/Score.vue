<template>
    <div>
        <div class="img-avatar">
            <div class="img-avatar_name">
                  {{(project.name || '').substring(0,1)}}
            </div>
            </div>
        <div>
            <div class="score-dropdown" @click="isPop = !isPop">
                <!-- trigger -->
                <span v-if="points <= 49" role="button" class="score-point score-point_cold">{{points}}</span>
                <span v-if="points > 49" role="button" class="score-point score-point_hot">{{points}}</span>

                <!-- menu links -->
                <div class="score-dropdown_item" v-show=isPop>
                  <div class="score">
                      <div class="score-content">
                          <p class="score-content_para"><i class="far fa-clock"></i>The project started {{project.created_at}}. Currently is in its
                            <b>{{project.stage}}</b> stage
                          </p>
                          <div class="score-content_point">
                              <p class="score-content_point-para"><b>Top scoring factors</b></p>
                              <div class="row">
                                  <div class="col-md-3">
                                      <p class="score-content_point-cold">
                    <span v-if="points > 49"><span  class="score-content_point-hot_point">{{points}}</span><br><span class="score-content_point-hot_status">Hot</span></span>
                    <span v-else><span class="score-content_point-cold_point">{{points}}</span><br><span class="score-content_point-cold_status">Cold</span></span>
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
    props:['project','points','scores_detail'],
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
    },
}
</script>

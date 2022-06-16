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
                <span role="button" class="score-point" :class="'score-point_'+status">0</span>

                <!-- menu links -->
                <div class="score-dropdown_item" v-show=isPop>
                  <div class="score">
                      <div class="score-content">
                          <p class="score-content_para"><i class="far fa-clock"></i>The project started {{start}}. Currently in its
                            <b v-text="stagename()"></b> stage
                          </p>
                          <div class="score-content_point">
                              <p class="score-content_point-para"><b>Top rating factors</b></p>
                              <div class="row">
                                  <div class="col-md-3">
                                      <p class="score-content_point-cold">
                    <span><span  :class="'score-content_point-'+status+'_point'">0</span><br><span :class="'score-content_point-'+status+'_status'">{{status}}</span></span>
                  </p>
                                  </div>
                                  <div class="col-md-9">
                                      <div>
                                  <div>
                                    <p class="project-score"><span><i class="fas fa-arrow-up"></i></span> This feature will be updated soon</p>
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
    props:['projectName','start','stage','completed','status'],
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

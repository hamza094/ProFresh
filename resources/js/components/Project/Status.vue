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
                <span role="button" class="score-point" :class="'score-point_'+status">{{score}}</span>

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
                    <span><span  :class="'score-content_point-'+status+'_point'">{{score}}</span><br><span :class="'score-content_point-'+status+'_status'">{{status}}</span></span>
                  </p>
                    </div>
                    <div class="col-md-9">
                    <div>
                    <div>
                    <p class="project-score"><span><i class="fas fa-arrow-up"></i></span> Score counts on the new task added.</p>
                    <p class="project-score"><span><i class="fas fa-arrow-up"></i></span> Score counts if project notes are available.
                    </p>
                    <p class="project-score"><span><i class="fas fa-arrow-up"></i></span>Score counts when a new member joins a project.</p>
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
    props:['projectName','start','stage','completed','status','score'],
    data() {
        return {
            isPop:false,
            loading: false,
        }
    },
    watch:{
        isPop(isPop){
            if(isPop){
            document.addEventListener('click', (event) => this.$options.methods.handleClickOutside.call(this, event, '.score-dropdown', this.isPop));
            }
        }
    },
    mounted(){
      this.loading=true;
    },
    methods: {
        stagename(){
        return this.currentStage(this.stage,this.completed);
     },
    },
}
</script>

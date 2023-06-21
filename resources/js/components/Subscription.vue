<template>
<div>
        <div class="page-top">Your Membership</div>
        <div class="container">
            <div v-if="subscription.subscribed" class="m-5 text-center">
      <h3>
          You are currently subscribed to our {{subscription.plan}} plan
      </h3>

        <div v-if="this.subscription.grace_period" class="alert alert-primary" role="alert">
            <i class="fas fa-exclamation-circle"></i> Alert: Your subscription has been canceled, and you are currently in the grace period. Please note that during this time, you still have access to all subscription benefits.
        </div>
      
<div v-if="!this.subscription.grace_period">
        <p>
            <button v-if="subscription.plan === 'monthly'" class="btn btn-lg btn-link" @click.prevent="swap('yearly')">Change Subscription to Yearly with $100</button>
            <button v-else class="btn btn-lg btn-link" @click.prevent="swap('monthly')">Change Subscription to Monthly with $ 100</button>
        </p>

    <p>
       <button class="btn btn-sm btn-danger" @click.prevent="cancelSubscription()">Cancel Subscription</button>
    </p>
</div>
</div>

    <div v-else class="row m-5">
        <div class="col-md-6">
    <div class="card text-center">
    <div class="card-body">
    <p class="card-title subscription_heading">Monthly Subscription</p>
      <p class="card-text"><span class="subscription_value">$10
      </span> / <span>monthly</span>
      </p>
      <button class="btn btn-block btn-primary" @click="subscribe('monthly')"  :disabled="isIframeOpen || isOpeningIframe">Subscribe</button>
    </div>
        </div>
    </div>
        <div class="col-md-6">
        <div class="card text-center">
    <div class="card-body">
      <p class="card-title subscription_heading">Yearly Subscription</p>
      <p class="card-text">
     <span class="subscription_value">$100</span> / <span>yearly</span>
  </p>
      <button class="btn btn-block btn-primary" @click="subscribe('yearly')"  :disabled="isIframeOpen || isOpeningIframe">Subscribe</button>
    </div>
        </div>
        </div>
       <div v-if="isIframeOpen" class="iframe-container">
    <button @click="closeIframe" class="close-button">Close</button>
    <iframe :src="iframeSrc" class="iframe"></iframe>
  </div>
    </div>

    <div class="row" v-if="subscription?.receipts?.length > 0">
        <div class="col-md-6">
        <h3>Reciepts</h3>
        <div class="card">
            <div class="card-body">
                <div v-for="reciept in subscription.receipts">
                    <p>
                        <span>
                            {{reciept.paid_at | reciept_date}}
                        </span>
                         -
                         <span>
                             ${{reciept.amount}}
                         </span>
                         <span class="float-right">
                            <a  :href="reciept.receipt_url" target="_blank">Download</a>
                         </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
</template>
<script>
      import { mapState, mapMutations, mapActions } from 'vuex';

    export default{
        
    data(){
    return{
    isIframeOpen: false,
    isOpeningIframe: false,
    iframeSrc: ''
    };
    },
    mounted() {
     axios.get('api/v1/user/subscriptions')
     .then(response => {
        this.setSubscription(response.data.subscription); 
      })
      .catch(error => {
        console.error(error);
      });
    },

    methods:{
        ...mapMutations('subscribeUser',['setSubscription']),

    closeIframe() {
      this.isIframeOpen = false;
    },              

    subscribe(plan){
    if (this.isIframeOpen || this.isOpeningIframe) {
        return; 
      }
      this.isOpeningIframe = true;

      axios.get(`/api/v1/user/subscribe/${plan}`)
        .then(response => {
          this.iframeSrc = response.data.paylink;
          this.isIframeOpen = true;
          this.isOpeningIframe = false;
        })
        .catch(error => {
          console.error(error);
          this.isOpeningIframe = false;
        });
     },
        swap(plan)
        {
          this.sweetAlert('Switch to '+ plan +' plan').then((result) => {
          if (result.value) {
          axios.get(`/api/v1/user/subscription/swap/${plan}`).then(
           response=>{
            this.setSubscription(response.data.subscription); 
            this.$vToastify.success(response.data.message);
          }).catch(error=>{
        swal.fire("Failed!", error.response.data.message, "warning");
        });
        }
        });
        },
        cancelSubscription(){
            const plan = this.subscription.plan;
          this.sweetAlert('Yes, Cancel Subscription').then((result) => {
          if (result.value) {
          axios.get(`/api/v1/user/subscription/${plan}/cancel`).then(
           response=>{
            this.setSubscription(response.data.subscription); 
            this.$vToastify.info(response.data.message);
          }).catch(error=>{
        swal.fire("Failed!", error.response.data.message, "warning");
        });
        }
        });
        },

    },
    computed:{
        ...mapState('subscribeUser',['subscription']),
    },
        
    }
    
</script>

<style scoped>
.iframe-container {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 5px;
  z-index: 99999;
}

.iframe {
  width: 100%;
  height: 100%;
}
</style>
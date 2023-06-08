<template>
<div>
        <div class="page-top">Your Subscription</div>
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
      <h5 class="card-title">Monthly Subscription</h5>
      <p class="card-text">$ 10 </p>
      <button class="btn btn-sm btn-primary" @click="subscribe()">Subscribe</button>
    </div>
        </div>
    </div>
        <div class="col-md-6">
        <div class="card text-center">
    <div class="card-body">
      <h5 class="card-title">Yearly Subscription</h5>
      <p class="card-text">$ 100</p>
      <button class="btn btn-sm btn-primary">Subscribe</button>
    </div>
        </div>
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
    };
    },
        methods:{
        ...mapMutations('subscribeUser',['setSubscription']),
            subscribe(){
              axios.get('/api/v1/user/subscribe').
                then(response=>{
                //console.log(response);
                window.open(response.data.paylink, '_blank');

                  }).catch(error=>{
                 console.log(error);
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
            swal.fire("Failed!","There was  an errors","warning");
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
            swal.fire("Failed!","There was  an errors","warning");
        });
        }
        });
        }
    },
    computed:{
        ...mapState('subscribeUser',['subscription']),
    },
        
    }
    
</script>
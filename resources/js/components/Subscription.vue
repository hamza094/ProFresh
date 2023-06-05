<template>
<div>
        <div class="page-top">Your Subscription</div>
        <div class="container">
            <div v-if="subscription.subscribed" class="m-5 text-center">
      <h3>
          You are currently subscribed to our {{subscription.plan}} plan
      </h3>

        <p>
            <button v-if="subscription.plan === 'monthly'" class="btn btn-lg btn-link">Change Subscription to Yearly with $100</button>
            <button v-else class="btn  btn-lg">Change Subscription to Monthly with $ 100</button>
        </p>

    <p>
       <button class="btn btn-sm btn-danger">Cancel Subscription</button>
    </p>
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

    <div class="row">
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
            subscribe(){
              axios.get('/api/v1/user/subscribe').
                then(response=>{
                //console.log(response);
                window.open(response.data.paylink, '_blank');

                  }).catch(error=>{
                 console.log(error);
               });
            }
    },
    computed:{
        ...mapState('subscribeUser',['subscription']),
    },
        
    }
    
</script>
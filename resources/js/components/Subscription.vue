<template>
<div class="test-center">
        <div class="page-top">Your Subscription</div>

    <div class="row m-5">
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
      <h5 class="card-title">Annualy Subscription</h5>
      <p class="card-text">$ 100</p>
      <button class="btn btn-sm btn-primary">Subscribe</button>
    </div>
        </div>
        </div>
    </div>

</div>
</template>
<script>
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
        
    }
</script>
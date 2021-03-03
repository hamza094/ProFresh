@extends('header')
@section('crm')

    <div class="container-fluid">
    <div class="row">
    	<div class="col-md-8 page pd-r">
    <profile :user="{{json_encode($user)}}" :members="{{json_encode($members)}}"></profile>    	
    	</div>
    	<div class="col-md-4">
    		<h3>Subscriptions</h3>
            <h5><span><b>Monthly:$15</b></span>
                <span class="float-right"><b>Yearly:$150</b></span>
            </h5>
            <hr>
            @if ($user->subscribed('main')) 
            @if ($user->subscribedToPlan('price_1IJepYLbPiqgp3U5mqEuYgQr','main')) 
            <h5>You are Currently Subscribe to a yearly plan with a card</h5>
            @elseif($user->subscribedToPlan('price_1IJejOLbPiqgp3U5jzTsYjVW','main'))
            <h5>You are Currently Subscribe to a monthly plan with a card</h5>
            @endif
    
@elseif($paypal == 'subscribed')
<h5>You are Currently Subscribed with paypal</h5>
@else
              <h5>Subscribe with card: <i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard"></i> </h5>
             <label for="subscription-plan" class="form-label"><b>Select Subscription Plan:</b></label>
             <select name="plan" class="form-control mb-2" id="subscription-plan">
                            @foreach($plans as $key=>$plan)
                                <option value="{{$key}}">{{$plan}}</option>
                            @endforeach
                        </select>
      <input placeholder="Card Holder" class="form-control" id="card-holder-name" type="text">

<!-- Stripe Elements Placeholder -->
<div id="card-element"></div>

<button id="card-button" class="mt-2 btn btn-sm btn-primary" data-secret="{{ $intent->client_secret }}">
    Subscribe
</button>
<hr>
<h5>Subscribe with Paypal <i class="fab fa-paypal"></i> </h5>
<p>
    <div class="row">
        <div class="form-group col-xs-6 ml-4">
             <form action="{{route('create-aggreement','P-53V259570909182594RROAYI')}}" method="post">
                @csrf
        <button type="submit" class="btn btn-primary btn-sm">Monthly Subscription</button>
    </form>
        </div>
      <div class="form-group col-xs-6 ml-4">
               <form action="{{route('create-aggreement','P-94D04691SW198613W4RP2ZQQ')}}" method="post">
                @csrf
        <button type="submit" class="btn btn-primary btn-sm">Yearly Subscription</button>
    </form>
        </div>   
    </div>
    
</p>
@endif
    	</div>
    </div>	
    </div>



@endsection


  <script type="application/javascript">
window.addEventListener('load', function() {
            const stripe = Stripe('{{env('STRIPE_KEY')}}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            const plan = document.getElementById('subscription-plan').value;
            cardButton.addEventListener('click', async (e) => {
                const { setupIntent, error } = await stripe.handleCardSetup(
                    clientSecret, cardElement, {
                        payment_method_data: {
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                );
                if (error) {
                    // Display "error.message" to the user...
                } else {
                    // The card has been verified successfully...
                   console.log('handlig success', setupIntent.payment_method);

                   axios.post('/subscribe',{
                        payment_method: setupIntent.payment_method,
                        plan : plan
                    })

                }
            });
        })
    </script>
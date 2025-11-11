             <h5>Subscribe with card: <i class="fa-brands fa-cc-visa"></i> <i class="fa-brands fa-cc-mastercard"></i> </h5>
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
<h5>Subscribe with Paypal <i class="fa-brands fa-paypal"></i> </h5>
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



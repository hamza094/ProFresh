          
           @if ($user->subscribedToPlan('price_1IJepYLbPiqgp3U5mqEuYgQr','main')) 

            <h5>You are Currently Subscribe to a yearly plan with a card</h5>

            @elseif($user->subscribedToPlan('price_1IJejOLbPiqgp3U5jzTsYjVW','main'))
            
            <h5>You are Currently Subscribe to a monthly plan with a card</h5>

            @endif

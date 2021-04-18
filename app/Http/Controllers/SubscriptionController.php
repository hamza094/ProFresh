<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Stripe;
use App\Paypal\CreatePlan;
use App\Paypal\PaypalAgreement;
use Auth;

class SubscriptionController extends Controller
{
  
   /**
    * Subscription with stripe.
    */
  public function subscribe(Request $request)
  {
    $paymentMethod=$request->payment_method;

    $planId=$request->plan;

    auth()->user()->newSubscription('main',$planId)->create($paymentMethod);

    return response(['status'=>'success']);
  }

  /**
    * Create new paypal plan.
    */
  public function createPlan()
  {
    $plan = new CreatePlan();

    return $plan->create();
  }

  /**
   * List all paypal plan.
   */
  public function listPlan()
  {
    $plan = new CreatePlan();

    $listPlan= $plan->listPlan();

    return $listPlan;
  }

  /**
   * Show specific all paypal plan.
   * @param  int  $id
   */
  public function showPlan($id)
  {
    $plan = new CreatePlan();

    $showPlan= $plan->planDetail($id);

    return $showPlan;
  }

  /**
   * Activate paypal plan.
   * @param  int  $id
   */
  public function activePlan($id)
  {
    $plan = new CreatePlan();

    $active = $plan->active($id);

    return $active;
  }
  
  /**
   * Create paypal agreement.
   * @param  int  $id
   */
  public function createAgreement($id)
  {
    $agreement=new PaypalAgreement;

    return $agreement->create($id);
  }

  /**
   * Execute paypal agreement.
   */
  public function executeAgreement($status)
  {
    if($status=='true'){
      $agreement=new PaypalAgreement;

      $agreement->execute(request('token'));

      Auth::user()->paypal_info();

     return view('home');     
    }
  }
}

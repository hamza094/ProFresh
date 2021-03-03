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
    public function __construct()
  {
      $this->middleware('auth');
  }

  public function subscribe(Request $request){
  	$user=auth()->user();
     $paymentMethod=$request->payment_method;
     $planId=$request->plan;
     $user->newSubscription('main',$planId)->create($paymentMethod);
     return response(['status'=>'success']);
  }


  public function createPlan(){
    $plan = new CreatePlan();
    return $plan->create();
  }

  public function listPlan(){
     $plan = new CreatePlan();
    $listPlan= $plan->listPlan();
    return $listPlan;
  }

  public function showPlan($id){
     $plan = new CreatePlan();
    $showPlan= $plan->planDetail($id);
    return $showPlan;
  }

  public function activePlan($id){
    $plan = new CreatePlan();
    $active = $plan->active($id);
    return $active;
  }

  public function createAgreement($id){
    $agreement=new PaypalAgreement;
    return $agreement->create($id);
  }

  public function executeAgreement($status){
    if($status=='true'){
      $agreement=new PaypalAgreement;
      $agreement->execute(request('token'));
      Auth::user()->paypal_info();
     return view('home');     
    }
  }

}

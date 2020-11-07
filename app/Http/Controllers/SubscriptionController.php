<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Lead;

class SubscriptionController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function leadSubscribe(Lead $lead)
  {
     $lead->subscribe();
  }

  public function leadUnSubscribe(Lead $lead)
  {
     $lead->unsubscribe();
  }

}

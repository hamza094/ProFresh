<?php

namespace App\Paypal;

use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;

class CreatePlan extends Paypal{

	public function create()
	{
    $plan = $this->Plan();

    $paymentDefinition = $this->PaymentDefinition();

    $chargeModel = $this->ChargeModel();

   $paymentDefinition->setChargeModels(array($chargeModel));

   $merchantPreferences = $this->MerchantPreferences(); 

   $plan->setPaymentDefinitions(array($paymentDefinition));

   $plan->setMerchantPreferences($merchantPreferences);

   $output = $plan->create($this->apiContext);

   return $output;

}


  protected function Plan() :Plan
  { 
   $plan = new Plan();

    $plan->setName('ProFresh Online Subscription')
    ->setDescription('Monthly Subscription For profresh plan to access all features')
    ->setType('fixed');

    return $plan;
}

  protected function PaymentDefinition() :PaymentDefinition
  {
    $paymentDefinition = new PaymentDefinition();
    $paymentDefinition->setName('Regular Payments')
    ->setType('REGULAR')
    ->setFrequency('Year')
    ->setFrequencyInterval("1")
    ->setCycles("12")
    ->setAmount(new Currency(array('value' => 15, 'currency' => 'USD')));
    return $paymentDefinition;
  }

  protected function ChargeModel() :ChargeModel
  {
   $chargeModel = new ChargeModel();
    $chargeModel->setType('SHIPPING')
    ->setAmount(new Currency(array('value' => 0, 'currency' => 'USD')));

    return $chargeModel;
  }

protected function MerchantPreferences() :MerchantPreferences
{
  $merchantPreferences = new MerchantPreferences();

  $merchantPreferences->setReturnUrl(config
    ('services.paypal.url.executeAgreement.success'))
    ->setCancelUrl(config('services.paypal.url.executeAgreement.failure'))
    ->setAutoBillAmount("yes")
    ->setInitialFailAmountAction("CONTINUE")
    ->setMaxFailAttempts("0")
    ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

    return $merchantPreferences;
  }

  public function listPlan()
  {
    $params = array('page_size' => '5');

    $planList = Plan::all($params, $this->apiContext);

    return $planList;
  }

  public function planDetail($id)
  {
    $plan = Plan::get($id,$this->apiContext);

    return $plan;
  }

  public function active($id)
  {
    $createdPlan=$this->planDetail($id);

    $patch = new Patch();

    $value = new PayPalModel('{
           "state":"ACTIVE"
         }');

    $patch->setOp('replace')
        ->setPath('/')
        ->setValue($value);

    $patchRequest = new PatchRequest();

    $patchRequest->addPatch($patch);

    $createdPlan->update($patchRequest, $this->apiContext);

    $plan = Plan::get($createdPlan->getId(), $this->apiContext);

    return $plan;
  }
}

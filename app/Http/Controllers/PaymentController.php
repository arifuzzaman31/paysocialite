<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Stripe;
use Validator;
use Stripe\Error\Card;
// use Cartalyst\Stripe\Stripe;

class PaymentController extends Controller
{
	private $_api_context;
    public function __construct()
    {/** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            'AUOLqwymwsukIyViwWiFS403XIT2DTAmV4bU9ajTQbx8doBhgKO2hNASTOIVNPjF9DgfJNdtSC_82K-P',
            'EAPj3I3x5YvrU3DHcaLvsXfxCxsyg2gdMkGoITnhhaFbc54VxJmlIYed_vZ1fAnRT5HwpeTpFIs4PMoJ')
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function getPaypal()
    {
    	return view('paypal');
    }
    public function payWithpaypal(Request $request)
    {
    	$payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('Item 1') /** item name **/
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));
        
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your transaction description');
        
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
            ->setCancelUrl(URL::route('status'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
        	$payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex)
        {
        	if (\Config::get('app.debug')) {
        		\Session::put('error', 'Connection timeout');
                return Redirect::route('/');
            } else {
            	\Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::route('/');
            }

        }
        foreach ($payment->getLinks() as $link) {
        	if ($link->getRel() == 'approval_url') {
        		$redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
        	/** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
        return Redirect::route('/');
    }


    public function getPaymentStatus(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty($request->PayerID) || empty($request->token)) {

            \Session::put('error', 'Payment failed');
            return Redirect::to('/pay-with-paypal');

        }

        $payment = Payment::get($request->paymentId, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') {

            \Session::put('success', 'Payment success');
            return Redirect::to('/pay-with-paypal');

        }

        \Session::put('error', 'Payment failed');
        return Redirect::to('/pay-with-paypal');

    }

    

    public function getStripe()
    {
    	return view('stripe');
    }
    public function stripePost(Request $request)
    {
        // return ;
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([

                "amount" => (float) $request->amount * 100,

                "currency" => "usd",

                "source" => $request->stripeToken,

                "description" => "Test payment from Limmexbd.com." 

        ]);

        Session::flash('success', 'Payment successful!');

        return back();
    }

   /* public function postPaymentStripe(Request $request)
	{
		 $validator = Validator::make($request->all(), [
		 'card_no' => 'required',
		 'ccExpiryMonth' => 'required',
		 'ccExpiryYear' => 'required',
		 'cvvNumber' => 'required',
		 //'amount' => 'required',
		 ]);
		 $input = $request->all();
		 if ($validator->passes()) { 
		 	$input = array_except($input,array('_token'));

			$stripe = Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
			 try {
			 $token = $stripe->tokens()->create([
				 'card' => [
					 'number' => $request->get('card_no'),
					 'exp_month' => $request->get('ccExpiryMonth'),
					 'exp_year' => $request->get('ccExpiryYear'),
					 'cvc' => $request->get('cvvNumber'),
				 ],
			 ]);


			if (!isset($token['id'])) {
				 	return redirect()->route('addmoney.paymentstripe');
				 }
				 $charge = $stripe->charges()->create([
					 'card' => $token['id'],
					 'currency' => 'USD',
					 'amount' => 20.49,
					 'description' => 'wallet',
				 ]);
				 
				 if($charge['status'] == 'succeeded') {

				 // echo "<pre>";
				 // print_r($charge);exit();
				 	return redirect()->route('addmoney.paymentstripe');
				 } else {
				 	\Session::put('error','Money not add in wallet!!');
				 	return redirect()->route('addmoney.paymentstripe');
				 }
			 } catch (Exception $e) {
			 	\Session::put('error',$e->getMessage());
			 	return redirect()->route('addmoney.paymentstripe');
			 } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
			 	\Session::put('error',$e->getMessage());
			 	return redirect()->route('addmoney.paywithstripe');
			 } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
			 	\Session::put('error',$e->getMessage());
				 return redirect()->route('addmoney.paymentstripe');
			 }
		}
	 } */
}

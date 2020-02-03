@extends('app')
@section('content')
<div class="card" style="width: 25em; margin: auto; margin-top: 5%;">
  <h5 class="card-header">Paypal</h5>
  <div class="card-body">
  	@if($message = Session::get('success'))
       <div class="alert alert-success text-center">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{!! $message !!}</p>
        </div>
        <?php Session::forget('success');?>
    @endif
    @if($message = Session::get('error'))
       <div class="alert alert-danger text-center">
           <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{!! $message !!}</p>
        </div>
        <?php Session::forget('error');?>
    @endif
    <h5 class="card-title">Payment with Paypal</h5>
        <form class="needs-validation" method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">
            {{ csrf_field() }}
        <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="items">Total Item</label>
                    <input type="text" class="form-control" id="items" name="items">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="card_no">Card No:</label>
                    <input type="text" class="form-control" id="card_no" name="card_no">
                </div>
            </div>
          <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label for="validationCustom01">Enter Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount">
                </div>
            </div>
          <button class="btn btn-primary" type="submit">Pay with PayPal</button>
        </form>
        <!-- <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">
          {{ csrf_field() }}
          <h2 class="w3-text-blue">Payment Form</h2>
          
          <p>      
          <label class="w3-text-blue"><b>Enter Amount</b></label>
          <input class="w3-input w3-border" id="amount" name="amount" type="text"></p>      
          <button type="submit" class="w3-btn w3-blue">Pay with PayPal</button></p>
        </form> -->
    </div>
</div>
@endsection
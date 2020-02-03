@extends('app')
@section('content')
<!-- <div class="container"> -->
	<div class="col-md-4 m-auto">
	    <div class="card" style="width: 25rem; margin-top: 5%;">
	        <div class="card-header">
	            <div class="card-title"><h4>Pay</h4></div>
	            <div class="card-body">
	                <div class="row"> 
	                    <div class="col-md-4">
	                        <button class="btn btn-primary"><a href="{{ URL::to('pay-with-paypal') }}" class="text-white">Paypal</a></button>
	                    </div>
	                    <div class="col-md-4 offset-md-4">
	                        <button class="btn btn-primary float-right"><a href="{{ URL::to('pay-with-stripe') }}" class="text-white">Stripe</a></button>
	                    </div>  
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
<!-- </div> -->
@endsection
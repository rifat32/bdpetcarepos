@extends('layouts.app')
@section('title', 'Coupons')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Coupons
        <small>Coupons</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">Edit Coupon</h3>
        
        </div>
        <div class="box-body">
            @can('category.view')
          <form method="POST" action="{{route('coupons.update')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
<div class="row">


   
    <input type="hidden" class="form-control" name="id" id="id" value="{{$coupon->id}}" required />
 

  <div class="col-md-4">
    <label for="code">code</label>
    <input class="form-control" name="code" id="code" value="{{$coupon->code}}" readonly />
  </div>  
  <div class="col-md-4">
    <label for="type">type</label>
    <select class="form-control" name="type" id="type" required >
<option value="fixed" @if ($coupon->type == "fixed")
  selected
@endif

>fixed</option>
<option value="percentage" 

@if ($coupon->type == "percentage")
  selected
@endif


>percentage</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="amount">amount</label>
    <input class="form-control" name="amount" id="amount" required value="{{$coupon->amount}}" />
  </div>
  <div class="col-md-8">
    <label for="description">description</label>
    <textarea class="form-control" name="description" id="description">
{{$coupon->description}}
    </textarea>
  </div>
  <div class="col-md-4">
    <img 
                            src="{{env("APP_URL")}}/storage/img/{{$coupon->image}}"
                            height="60"
                            width="60"
                            />
    <label for="image">image</label>
    <input type="file" class="form-control" name="image" id="image" />
  </div>
  @php
  $expire_at = new DateTime($coupon->expire_at);
  $active_from = new DateTime($coupon->active_from);
  @endphp
  <div class="col-md-4">
    <label for="active_from">active from</label>
    <input type="date" class="form-control" name="active_from" id="active_from" required value="{{$active_from->format('Y-m-d')}}"/>
  </div>  
 
  <div class="col-md-4">
    
   

<label for="expire_at">expire at</label>
    <input type="date" class="form-control" name="expire_at" id="expire_at" required value="{{$expire_at->format('Y-m-d')}}" />
  </div>

  <div class="col-md-4">
    <label for="is_valid">valid</label>
    <select class="form-control" name="is_valid" id="is_valid" required >
<option value="1" @if ($coupon->is_valid)
  selected
@endif>Yes</option>
<option value="0" @if (!$coupon->is_valid)
  selected
@endif>No</option>
    </select>
  </div>

  
</div>

<div class="row " style="margin-top: 1rem;">
  
  <div class="col-md-12 text-center">
    <button class="btn btn-primary " type="submit">Submit</button>
  </div>
  
  
</div>





          </form>
            @endcan
        </div>
    </div>

    <div class="modal fade category_modal" tabindex="-1" role="dialog"
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

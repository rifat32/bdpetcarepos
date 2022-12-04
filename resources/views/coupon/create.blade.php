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
        	<h3 class="box-title">Create Coupon</h3>
        
        </div>
        <div class="box-body">
            @can('category.view')
          <form method="POST" action="{{route('coupons.store')}}" enctype="multipart/form-data">
            {{ csrf_field() }}
<div class="row">
   
  <div class="col-md-4">
    <label for="type">type</label>
    <select class="form-control" name="type" id="type" required>
<option value="fixed">fixed</option>
<option value="percentage">percentage</option>
    </select>
  </div>
  <div class="col-md-4">
    <label for="amount">amount</label>
    <input class="form-control" name="amount" id="amount" required />
  </div>
  <div class="col-md-8">
    <label for="description">description</label>
    <textarea class="form-control" name="description" id="description">

    </textarea>
  </div>
  <div class="col-md-4">
    <label for="image">image</label>
    <input type="file" class="form-control" name="image" id="image" />
  </div>
  <div class="clearfix"></div>

  <div class="col-md-4">
    <label for="active_from">active from</label>
    <input type="date" class="form-control" name="active_from" id="active_from" required />
  </div>  
 
  <div class="col-md-4">
    <label for="expire_at">expire at</label>
    <input type="date" class="form-control" name="expire_at" id="expire_at" required />
  </div>

  <div class="col-md-4">
    <label for="is_valid">valid</label>
    <select class="form-control" name="is_valid" id="is_valid" required >
<option value="1">Yes</option>
<option value="0">No</option>
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

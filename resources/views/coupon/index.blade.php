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
        	<h3 class="box-title">Manage Coupon</h3>
            
            @can('category.create')
        	<div class="box-tools">
                <a  class="btn btn-block btn-primary "
                	href="{{action('CouponController@create')}}"
                	>
                	<i class="fa fa-plus"></i> @lang( 'messages.add' )</a>
            </div>
            @endcan
        </div>
        @if (Session::has("message"))
        <h4 class="text-center bg-success">{{Session::get("message")}}</h4> 
        @endif
        
        <div class="box-body">
            @can('category.view')
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" >
        		<thead>
        			<tr>
        				<th>Id</th>
        				<th>Code</th>
                        <th>description</th>
                        <th>image</th>
                        <th>type</th>
                        <th>amount</th>
                        <th>active from</th>
                        <th>expire at</th>
                        <th>valid</th>
                        <th>@lang( 'messages.action' )</th>
        			</tr>
        		</thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                    <tr>
        				<td>{{$coupon->id}}</td>
        				<td>{{$coupon->code}}</td>
                        <td>{{$coupon->description}}</td>
                        <td><img 
                            src="{{env("APP_URL")}}/storage/img/{{$coupon->image}}"
                            height="60"
                            width="60"
                            /></td>
                        <td>{{$coupon->type}}</td>
                        <td>{{$coupon->amount}}</td>
                        <td>{{$coupon->active_from}}</td>
                        <td>{{$coupon->expire_at}}</td>
                        <td>{{($coupon->is_valid)?"yes":"no"}}</td>
                        <td>
                            <a href="{{route("coupons.edit",$coupon->id)}}" class="btn btn-primary" > 
                        Edit
                        </a>
                        <a href="{{route("coupons.delete",$coupon->id)}}" class="btn btn-danger" > 
                            Delete
                            </a>
                    
                    </td>
        			</tr>
                    @endforeach
                </tbody>
        	</table>
            {{$coupons->links()}}
            </div>
            @endcan
        </div>
    </div>

    <div class="modal fade category_modal" tabindex="-1" role="dialog"
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

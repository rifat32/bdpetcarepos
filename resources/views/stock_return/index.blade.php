@extends('layouts.app')
@section('title', __('Purchase Return'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Purchase Return List
        <small></small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">Purchase Return List</h3>
            <div class="box-tools">
                <a class="btn btn-block btn-primary" href="{{action('StockReturnController@create')}}">
                <i class="fa fa-plus"></i> @lang('messages.add')</a>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="stock_adjustment_table">
        		<thead>
        			<tr>
        				<th>@lang('messages.date')</th>
                        <th>@lang('purchase.ref_no')</th>
                        <th>@lang('business.location')</th>
                        <th>@lang('stock_adjustment.supplier_name')</th>
                        <th>@lang('stock_adjustment.total_amount')</th>
                        <th>@lang('stock_adjustment.reason_for_stock_adjustment')</th>
						<th>@lang('messages.action')</th>
        			</tr>
        		</thead>
        	</table>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
@stop
@section('javascript')
{{--<script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>--}}
    <script src="{{asset('js/print/printPage.js')}}"></script>
	<script src="{{ asset('js/stock_return.js?v=' . $asset_v) }}"></script>
@endsection
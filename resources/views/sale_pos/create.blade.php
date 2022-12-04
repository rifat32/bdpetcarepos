@extends('layouts.app')

@section('title', 'POS')

@section('content')

<!-- Content Header (Page header) -->
<!-- <section class="content-header">
    <h1>Add Purchase</h1> -->
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
<!-- </section> -->
<input type="hidden" id="__precision" value="{{config('constants.currency_precision')}}">

<!-- Main content -->
{!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'id' => 'add_pos_sell_form' ]) !!}
<section class="content no-print" style="background: #0a9ca3;">
	<div class="row"  >
		{{-- @@@now --}}
		<div  class="col-md-4 col-sm-12" style="background:#dae6e4; height:85vh;border:1px solid #0a9ca3;"  >
			<div 
			{{-- class="box box-success"  --}}
			
			>

				<div class="box-header with-border">
					<div class="col-sm-4">
                        @include('layouts.partials.header-pos')
					</div>
					<div class="col-sm-4 " style="text-align: center;">
						<h3 class="box-title" style="font-size:2.3rem;">POS Terminal <i class="fa fa-keyboard-o hover-q text-muted" aria-hidden="true" data-container="body" data-toggle="popover" data-placement="bottom" data-content="@include('sale_pos.partials.keyboard_shortcuts_details')" data-html="true" data-trigger="hover" data-original-title="" title=""></i></h3>
					</div>
					<div class="col-sm-4">
                        @include('layouts.partials.header-pos2')
					</div>
                   

					<input type="hidden" id="item_addition_method" value="{{$business_details->item_addition_method}}">
					@if(is_null($default_location))
						<div class="col-sm-6">
							<div class="form-group" style="margin-bottom: 0px;">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-map-marker"></i>
									</span>

								{!! Form::select('select_location_id', $business_locations, null, ['class' => 'form-control input-sm mousetrap',
								'placeholder' => __('lang_v1.select_location'),
								'id' => 'select_location_id',
								'required', 'autofocus'], $bl_attributes); !!}
								<span class="input-group-addon">
										@show_tooltip(__('tooltip.sale_location'))
									</span>
								</div>
							</div>
						</div>
					@endif

				</div>



				{!! Form::hidden('location_id', $default_location, ['id' => 'location_id', 'data-receipt_printer_type' => isset($bl_attributes[$default_location]['data-receipt_printer_type']) ? $bl_attributes[$default_location]['data-receipt_printer_type'] : 'browser']); !!}

				<!-- /.box-header -->
				<div class="box-body" style="height:1%;">
					<div class="row">
						@if(config('constants.enable_sell_in_diff_currency') == true)
							<div class="col-md-4 col-sm-6">
								<div class="form-group">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-exchange"></i>
										</span>
										{!! Form::text('exchange_rate', config('constants.currency_exchange_rate'), ['class' => 'form-control input-sm input_number', 'placeholder' => __('lang_v1.currency_exchange_rate'), 'id' => 'exchange_rate']); !!}
									</div>
								</div>
							</div>
						@endif
						@if(!empty($price_groups))
							@if(count($price_groups) > 1)
								<div class="col-md-4 col-sm-6">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											@php
												reset($price_groups);
											@endphp
											{!! Form::hidden('hidden_price_group', key($price_groups), ['id' => 'hidden_price_group']) !!}
											{!! Form::select('price_group', $price_groups, null, ['class' => 'form-control select2', 'id' => 'price_group', 'style' => 'width: 100%;']); !!}
											<span class="input-group-addon">
												@show_tooltip(__('lang_v1.price_group_help_text'))
											</span>
										</div>
									</div>
								</div>
							@else
								@php
									reset($price_groups);
								@endphp
								{!! Form::hidden('price_group', key($price_groups), ['id' => 'price_group']) !!}
							@endif
						@endif
					</div>
					<div class="row" >
						<div class="@if(!empty($commission_agent)) col-sm-4 @else col-sm-6 @endif">
							<div class="form-group" style="width: 100% !important">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
										@if($walk_in_customer)
										<input type="hidden" id="default_customer_id"
									value="{{ $walk_in_customer['id']}}" >
									<input type="hidden" id="default_customer_name"
									value="{{ $walk_in_customer['name']}}" >
									@endif
									{!! Form::select('contact_id',
										[], null, ['class' => 'form-control mousetrap', 'id' => 'customer_id', 'placeholder' => 'Enter Customer name / phone', 'required', 'style' => 'width: 100%;']); !!}
									<span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat add_new_customer" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>
								</div>
							</div>
						</div>
                        {{-- <div class="col-sm-4 ">
							<div class="form-group" style="width: 100% !important">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>




									{!! Form::select('doctor_id',
										[], null, ['class' => 'form-control mousetrap', 'id' => 'doctor_id', 'placeholder' => 'Enter Doctor Name / phone', 'style' => 'width: 100%;']); !!}
									<span class="input-group-btn">
										<a href="{{action('DoctorController@create')}}"  class="btn btn-default bg-white btn-flat add_new_doctor" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
									</span>
								</div>
							</div>
						</div> --}}
						<div class="col-sm-6">
							<p >
								<span id="sell_due" style="font-weight: bold;color:red;"></span> <br>
								<span id="sell_return_due" style="font-weight: bold;
								color:black;"></span>
							</p>

						</div>
						<br>
						@if($walk_in_customer)
									<input type="hidden" name="pay_term_number" id="pay_term_number" value="{{$walk_in_customer['pay_term_number']}}">
						<input type="hidden" name="pay_term_type" id="pay_term_type" value="{{$walk_in_customer['pay_term_type']}}">
									@endif

						@if(!empty($commission_agent))
							<div class="col-sm-4">
								<div class="form-group">
								{!! Form::select('commission_agent',
											$commission_agent, null, ['class' => 'form-control select2', 'placeholder' => __('lang_v1.commission_agent')]); !!}
								</div>
							</div>
						@endif

						<div class="@if(!empty($commission_agent)) col-sm-4 @else col-sm-12 @endif">
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-barcode"></i>
									</span>
									{!! Form::text('search_product', null, ['class' => 'form-control mousetrap', 'id' => 'search_product', 'placeholder' => __('lang_v1.search_product_placeholder'),
									'disabled' => is_null($default_location)? true : false,
									'autofocus' => is_null($default_location)? false : true,
									]); !!}

									<span class="input-group-btn">
										<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="{{action('ProductController@quickAdd')}}" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
									</span>

								</div>
							</div>
						</div>


						{{--<div class="col-md-4">
							<div class="form-group">
								<select name="service_center_id" class="form-control" required id="service_center_id">
									<option value="" hidden>Select service Center</option>
									@foreach($services as $service)
									<option value="{{ $service->id}}">{{ $service->bar_name}}</option>
									@endforeach
								</select>

							</div>
						</div>--}}


					{{--	<div class="col-md-4">
							<div class="form-group">
								<select name="table_id" class="form-control select2" required>
									<option value="" hidden>Select Your Table</option>
									@foreach($tables as $table)
									<option value="{{ $table->id}}">{{ $table->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						--}}
                  	{{--
						<div class="col-md-4">
							<div class="form-group">
								<select name="sub_table" class="form-control select2" required>
									<option value="" hidden>Select Your Chair</option>
								@foreach($subs as $sub)
									<option value="{{ $sub->id}}">{{ $sub->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						--}}



						<div class="clearfix"></div>

						<!-- Call restaurant module if defined -->
			        </div>


					<div class="row col-sm-12 pos_product_div">

						<input type="hidden" name="sell_price_tax" id="sell_price_tax" value="{{$business_details->sell_price_tax}}">

						<!-- Keeps count of product rows -->
						<input type="hidden" id="product_row_count"
							value="0">
						@php
							$hide_tax = '';
							if( session()->get('business.enable_inline_tax') == 0){
								$hide_tax = 'hide';
							}
						@endphp
						<div class="row" style="height: 25rem;overflow-y:auto;">
							<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table" style="background: white;" >
								<thead>
									<tr>
										<th class="tex-center col-md-4">
											@lang('sale.product') @show_tooltip(__('lang_v1.tooltip_sell_product_column'))
	
	
										</th>
										<th class="text-center col-md-3">
											@lang('sale.qty')
										</th>
										<th class="text-center col-md-2 {{$hide_tax}}">
											@lang('sale.price_inc_tax')
										</th>
										<th class="text-center col-md-3">
											@lang('sale.subtotal')
										</th>
										<th class="text-center col-md-3">
											Cost
										</th>
	
										<th class="text-center"><i class="fa fa-close" aria-hidden="true"></i></th>
									</tr>
								</thead>
								<tbody>
	
								</tbody>
							</table>
						</div>
						<div class="row">
							
								<div class="text-center">
									<label for="discount_amount_1">Discount:</label>
									<input type="text" name="discount_amount_1" id="discount_amount_1">
								</div>
								
								<h3 class="text-center" style="margin: 0">
									total: <span id="subtotal1" style="display: none;"></span>
									<span id="total1"></span>
									<input type="hidden" name="total_1" id="total_1">
								</h3>
								
							
							
						</div>
						



					</div>



@if(isset($transaction))
@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $transaction->discount_amount, 'discount_type' => $transaction->discount_type])
@else
@include('sale_pos.partials.edit_discount_modal', ['sales_discount' => $business_details->default_sales_discount, 'discount_type' => 'percentage'])
@endif

@if(isset($transaction))
@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $transaction->tax_id])
@else
@include('sale_pos.partials.edit_order_tax_modal', ['selected_tax' => $business_details->default_sales_tax])
@endif

@if(isset($transaction))
@include('sale_pos.partials.edit_shipping_modal', ['shipping_charges' => $transaction->shipping_charges, 'shipping_details' => $transaction->shipping_details])
@else
@include('sale_pos.partials.edit_shipping_modal', ['shipping_charges' => '0.00', 'shipping_details' => ''])
@endif		

					@include('sale_pos.partials.payment_modal')

					@if(empty($pos_settings['disable_suspend']))
						@include('sale_pos.partials.suspend_note_modal')
					@endif
				</div>
				<!-- /.box-body -->

			</div>
			<!-- /.box -->
		</div>

		{{-- @@@now --}}
		<div class="col-md-4 col-sm-12" style="background:#dae6e4; height:85vh;border:1px solid #0a9ca3;"   >
			{{-- @include('sale_pos.partials.right_div') --}}

			<h2 class="text-center" style="font-weight:bold;">Service Sell</h2>
            <div class="row" style=" margin-top: 0rem;">
                <div class=" col-sm-12 ">
					<h2 class="text-center" style="">Doctor</h2>
                    <div class="form-group" style="width: 100% !important; margin:0;">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </span>




                            {!! Form::select('doctor_id',
                                [], null, ['class' => 'form-control mousetrap', 'id' => 'doctor_id', 'placeholder' => 'Enter Doctor Name / phone', 'style' => 'width: 100%;']); !!}
                            <span class="input-group-btn">
                                <a href="{{action('DoctorController@create')}}"  class="btn btn-default bg-white btn-flat add_new_doctor" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
				
                <div class="col-sm-12 ">
                    <div class="form-group" style="margin:0; padding:0;">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-barcode"></i>
                            </span>
                            {!! Form::text('search_product2', null, ['class' => 'form-control mousetrap', 'id' => 'search_product2', 'placeholder' => __('lang_v1.search_product_placeholder'),
                            'disabled' => is_null($default_location)? true : false,
                            'autofocus' => is_null($default_location)? false : true,
                            ]); !!}

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="{{action('ProductController@quickAdd')}}" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
                            </span>

                        </div>
                    </div>
                </div>
				<div class="col-sm-12" style="height: 25rem;overflow-y:auto;  margin-top: 2.5rem; ">
					<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table2" style="background: white; ">
						<thead>
							<tr>
								<th class="tex-center col-md-4">
									@lang('sale.product') @show_tooltip(__('lang_v1.tooltip_sell_product_column'))
		
		
								</th>
								<th class="text-center col-md-3">
									@lang('sale.qty')
								</th>
								<th class="text-center col-md-2 {{$hide_tax}}">
									@lang('sale.price_inc_tax')
								</th>
								<th class="text-center col-md-3">
									@lang('sale.subtotal')
								</th>
								<th class="text-center col-md-3">
									Cost
								</th>
		
								<th class="text-center"><i class="fa fa-close" aria-hidden="true"></i></th>
							</tr>
						</thead>
						<tbody>
		
						</tbody>
					</table>
					
				</div>
				<div class="col-sm-12">
					<div class="row" style="">
						<div class="text-center">
							<label for="discount_amount_2">Discount:</label>
							<input type="text" name="discount_amount_2" id="discount_amount_2">
						</div>
						
						<h3 class="text-center" style="margin: 0">
							total: <span id="subtotal2" style="display: none;"></span>
							<span id="total2"></span>
							<input type="hidden" name="total_2" id="total_2">
						</h3>
						
					</div>
				</div>
				
				
            </div>
			
		


          
		</div>
			{{-- @@@now --}}
			<div class="col-md-4 col-sm-12" style="background:#dae6e4; height:85vh; border:1px solid #0a9ca3;"   >
				{{-- @include('sale_pos.partials.right_div') --}}
	
				<h2 class="text-center" style="font-weight:bold;">Service Sell</h2>
			
				{{--@@@@@@@@@@@@@@@ assistant @@@@@@@@@@@@@@@ --}}
				<div class="row" style=" margin-top: 0rem;" >
				  
					<div class=" col-sm-12 ">
						<h2 class="text-center" style="">Assistant</h2>
						<div class="form-group" style="width: 100% !important;margin:0; padding:0;">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-user"></i>
								</span>
	
								{!! Form::select('assistant_id',
									[], null, ['class' => 'form-control mousetrap', 'id' => 'assistant_id', 'placeholder' => 'Enter Assistant Name / phone', 'style' => 'width: 100%;']); !!}
								<span class="input-group-btn">
									<a href="{{action('AssistantController@create')}}"  class="btn btn-default bg-white btn-flat add_new_doctor" data-name=""  @if(!auth()->user()->can('customer.create')) disabled @endif><i class="fa fa-plus-circle text-primary fa-lg"></i></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-sm-12 ">
						<div class="form-group" style="margin:0; padding:0;">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-barcode"></i>
								</span>
								{!! Form::text('search_product3', null, ['class' => 'form-control mousetrap', 'id' => 'search_product3', 'placeholder' => __('lang_v1.search_product_placeholder'),
								'disabled' => is_null($default_location)? true : false,
								'autofocus' => is_null($default_location)? false : true,
								]); !!}
	
								<span class="input-group-btn">
									<button type="button" class="btn btn-default bg-white btn-flat pos_add_quick_product" data-href="{{action('ProductController@quickAdd')}}" data-container=".quick_add_product_modal"><i class="fa fa-plus-circle text-primary fa-lg"></i></button>
								</span>
	
							</div>
						</div>
					</div>
					<div class="col-sm-12" style="height: 25rem;overflow-y:auto; margin-top: 2.5rem;">
						<table class="table table-condensed table-bordered table-striped table-responsive" id="pos_table3" style="background: white; ">
							<thead>
								<tr>
									<th class="tex-center col-md-4">
										@lang('sale.product') @show_tooltip(__('lang_v1.tooltip_sell_product_column'))
			
			
									</th>
									<th class="text-center col-md-3">
										@lang('sale.qty')
									</th>
									<th class="text-center col-md-2 {{$hide_tax}}">
										@lang('sale.price_inc_tax')
									</th>
									<th class="text-center col-md-3">
										@lang('sale.subtotal')
									</th>
									<th class="text-center col-md-3">
										Cost
									</th>
			
									<th class="text-center"><i class="fa fa-close" aria-hidden="true"></i></th>
								</tr>
							</thead>
							<tbody>
			
							</tbody>
						</table>
					</div>
					<div class="col-sm-12">
						<div class="row" style="">
							<div class="text-center">
								<label for="discount_amount_3">Discount:</label>
								<input type="text" name="discount_amount_3" id="discount_amount_3">
							</div>
							
							<h3 class="text-center" style="margin: 0">
								total: <span id="subtotal3" style="display: none;"></span>
								<span id="total3"></span>
								<input type="hidden" name="total_3" id="total_3">
							</h3>
							
						</div>
					</div>
				</div>
	
	
	
			  
			</div>
	</div>
	<div class="row " style="margin-top:-20rem; position:fixed; bottom:0; width: 100%;">
		<div style="
width: 50%; margin:auto;">
	@include('sale_pos.partials.pos_details')
</div>
	</div>
</section>
{!! Form::close() !!}
<!-- This will be printed -->
<section class="invoice print_section" id="receipt_section">
</section>
<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog"
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog"
	aria-labelledby="gridSystemModalLabel">
</div>
<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

@stop

@section('javascript')

    <script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>



	<script src="{{ asset('js/printer.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/product.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('js/opening_stock.js?v=' . $asset_v) }}"></script>
	@include('sale_pos.partials.keyboard_shortcuts')

	<!-- Call restaurant module if defined -->
    @if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
    	<script src="{{ asset('js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
@endsection

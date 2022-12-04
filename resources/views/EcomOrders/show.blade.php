
@extends('layouts.app')
@section('title', "orders")

@section('content')

<section class="content-header">
    <h1>
        Details
    </h1>
    @php
     $sell =  \App\Transaction::where(["order_id" => $order->id])->first();
    @endphp
    @if($sell)
    <h1>
        <a class="btn btn-danger text-capitalize" href="{{action('SellPosController@edit', [$sell->id])}}" >already sold to pos </a>
        
    </h1>
    @else
    @if ($order->delivery_status != "cancelled")
    <h1>
        <a class="btn btn-primary text-capitalize" href="{{route('create.ecommerce.sell',$order->id)}}">convert to pos sell</a>
        
    </h1>
    @endif
 
    @endif
   
</section>

<div class="card container" style="width:90%;">
    <div class="card-header">
        <h1 class="h2 fs-16 mb-0">Order Details</h1>
    </div>
    <div class="card-body">
        <div class="row gutters-5">
            <div class="col text-center text-md-left">
            </div>
            @php
            $delivery_status = $order->delivery_status;
            $payment_status = $order->payment_status;
            @endphp


<div class="col-md-3">

</div>

{{-- <div class="col-md-3 ml-auto">
    <label for="update_delivery_man">Delivery Man</label>

        <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_man" name="update_delivery_man">
            <option value="" @if ($order->delivery_man == '') selected @endif>Please Select</option>
            @foreach ($deliveryMans as  $delivery_man)
            <option value="{{$delivery_man->name}}" @if ($delivery_man->name == $order->delivery_man ) selected @endif>{{$delivery_man->name}}</option>
   @endforeach

        </select>


</div> --}}



            <div class="col-md-3 ml-auto">
                <label for="update_payment_status">Payment Status</label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_payment_status">
                    <option value="unpaid" @if ($payment_status == 'unpaid') selected @endif>Unpaid</option>
                    <option value="paid" @if ($payment_status == 'paid') selected @endif>Paid</option>
                </select>
            </div>
            <div class="col-md-3 ml-auto">
                <label for="update_delivery_status">Delivery Status</label>
                @if($delivery_status != 'delivered' && $delivery_status != 'cancelled' && $delivery_status != 'return')
                    <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_delivery_status">
                        <option value="pending" @if ($delivery_status == 'pending') selected @endif>Pending</option>
                        <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>Confirmed</option>

                        <option value="on_the_way" @if ($delivery_status == 'on_the_way') selected @endif>On The Way</option>
                        <option value="delivered" @if ($delivery_status == 'delivered') selected @endif>Delivered</option>
                        <option value="return" @if ($delivery_status == 'return') selected @endif>Return</option>
                        <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>Cancel</option>
                    </select>
                @else
                    <input type="text" class="form-control" value="{{ $delivery_status }}" disabled>
                @endif
            </div>
        </div>
    
        <div class="row gutters-5">
            <div class="col-md-4 text-center text-md-left">
                <address>
                    <strong class="text-main">@if($order->user) {{ $order->user->name }} @endif  </strong><br>
                 @if($order->user) {{ $order->user->email }} @endif <br>
                 @if($order->user) <strong class="text-main"> user phone number:</strong> {{ $order->user->phone }} @endif <br>
                <strong class="text-main">     phone number used in order:</strong> {{ json_decode($order->shipping_address)->phone }}<br>

                {{ !empty(json_decode($order->shipping_address)->title)?json_decode($order->shipping_address)->title :"" }}<br>
                {{ !empty(json_decode($order->shipping_address)->state)?json_decode($order->shipping_address)->state:"" }}<br>
                 {{ !empty(json_decode($order->shipping_address)->postal_code)?json_decode($order->shipping_address)->postal_code:"" }}<br>
                    {{ !empty(json_decode($order->shipping_address)->address)?json_decode($order->shipping_address)->address:"" }}<br>
                    {{ !empty(json_decode($order->shipping_address)->city)?json_decode($order->shipping_address)->city:"" }}<br>
                    {{-- {{ json_decode($order->shipping_address)->postal_code }}<br> --}}
                    {{ !empty(json_decode($order->shipping_address)->country)?json_decode($order->shipping_address)->country:"" }} 
                </address>

                @if ($order->manual_payment && is_array(json_decode($order->manual_payment_data, true)))
                <br>
                <strong class="text-main">Payment Information</strong><br>
                Name: {{ json_decode($order->manual_payment_data)->name }}, Amount: {{ json_decode($order->manual_payment_data)->amount }}, TRX ID
                : {{ json_decode($order->manual_payment_data)->trx_id }}
                <br>
                <a href="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" target="_blank"><img src="{{ uploaded_asset(json_decode($order->manual_payment_data)->photo) }}" alt="" height="100"></a>
                @endif
            </div>
            <div class="col-md-4 ml-auto"></div>
            <div class="col-md-4 ml-auto">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-main text-bold">Order #</td>
                            <td class="text-right text-info text-bold">	{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">Order Status</td>
                            <td class="text-right">
                                @if($delivery_status == 'delivered')
                                <span class="badge badge-inline badge-success">{{ ucfirst(str_replace('_', ' ', $delivery_status)) }}</span>
                                @else
                                <span class="badge badge-inline badge-info">{{ ucfirst(str_replace('_', ' ', $delivery_status)) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">Order Date	</td>
                            <td class="text-right">{{ date('d-m-Y h:i A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">
                                Total amount
                            </td>
                            <td class="text-right">
                                {{$order->grand_total}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-main text-bold">Payment method</td>
                            <td class="text-right">{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr class="new-section-sm bord-no">
        <div class="row">
            <div class="row">
                <div class="col-md-4 ">
                    <input type="text" class="form-control" id="search_product">
                </div>
                <div class="col-md-4 ">
                    <button type="button" class="btn btn-primary" onclick="search()">search product</button>
                </div>
                
            </div>
            <form id="products">
            <div class="col-lg-12 table-responsive">
                <table class="table table-bordered aiz-table invoice-summary">
                    <thead>
                        <tr class="bg-trans-dark">
                            <th data-breakpoints="lg" class="min-col">#</th>
                            <th width="10%">Photo</th>
                            <th class="text-uppercase">Description</th>
                            <th data-breakpoints="lg" class="text-uppercase">Delivery Type</th>
                            <th data-breakpoints="lg" class="min-col text-center text-uppercase">Qty</th>
                            <th data-breakpoints="lg" class="min-col text-center text-uppercase">Price</th>
                            <th data-breakpoints="lg" class="min-col text-right text-uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyproduct" class="tbodyproduct">
                        @foreach ($order->orderDetails as $key => $orderDetail)
                        <tr id="products[{{$key}}]">

                            <td>{{ $key+1 }}
                            
                            
                            </td>
                            <td>
                                @if ($orderDetail->product != null)
                                <a href="{{ route('product.view', $orderDetail->product->product->id) }}" target="_blank"><img height="50" src="{{ asset(('/storage/img/' . $orderDetail->product->product->image)) }}"></a>
                                @else
                                <strong>N/A</strong>
                                @endif
                            </td>
                            <td>
                                @if ($orderDetail->product != null)
                                <strong><a href="{{ route('product.view', $orderDetail->product->id) }}" target="_blank" class="text-muted">{{ $orderDetail->product->product->name }}</a></strong>
                                <small>{{ ($orderDetail->product->name == "DUMMY")?"":$orderDetail->product->name }} </small>
                                @else
                                <strong>Product Unavailable</strong>
                                @endif
                            </td>
                            <td>

                                @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
                               Home Delivery

                                @elseif ($orderDetail->shipping_type == 'pickup_point')

                                @if ($orderDetail->pickup_point != null)
                                {{ $orderDetail->pickup_point->getTranslation('name') }} ({{ translate('Pickup Point') }})
                                @else
                                {{ translate('Pickup Point') }}
                                @endif
                                @endif
                            </td>
                            <td class="text-center">
                                <span
                                onclick="decreaseValue('products[{{$key}}]')" 
                                class="input-group-btn"><button type="button" class="btn btn-small d-inline quantity-down"><i class="fa fa-minus text-danger"></i></button></span>

                                <input 
                                type="text" 
                                data-min="1" 
                                class="form-control pos_quantity input_number mousetrap" value="{{@num_format($orderDetail->quantity)}}" name="products-{{$key}}-quantity"
                                id="products[{{$key}}][quantity]"
                                >


        <p   id="products-{{$key}}-info">{{$orderDetail->price}}-{{$orderDetail->product->id}}-{{$orderDetail->product->product->id}}-0-{{$orderDetail->product->variation_location_details[0]->qty_available}}-e-e-e-e-e</p>


                             







                                <span
                                onclick="increaseValue('products[{{$key}}]')" 
                                class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span> 
                                
                              

{{--                                 
                                {{ $orderDetail->quantity }} --}}
                            
                            


                            </td>
                            <td class="text-center" >
                                <span id="products[{{$key}}][price]">{{$orderDetail->price}}</span>
                            </td>
                            <td class="text-center" >
            <span  id="products[{{$key}}][total]">{{$orderDetail->price*$orderDetail->quantity}}</span>
                                
                            </td>
                           

                            <td class="text-center"> <button onclick="deleteRaw('products[{{$key}}]')" class="btn btn-danger">X</button> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
        </div>
        <script>
         


            function increaseValue(id) {
  var value = parseInt(document.getElementById(`${id}[quantity]`).value, 10);
  value = isNaN(value) ? 0 : value;
  value++;
  document.getElementById(`${id}[quantity]`).value = value;
  let price =  (document.getElementById(`${id}[price]`).innerHTML * 1);
  document.getElementById(`${id}[total]`).innerHTML = price * value;


//   let info= document.getElementById(`${id}-qty`).innerHTML;
//         const infos = info.split("-");
//         console.log(info);

//         if(parseInt(infos[4]) < parseInt(el.value)) {
//             let errorDom = document.getElementById(`products-${infoId}-info`)
//             errorDom.style.color = 'red';
//          errorDom.style.color = 'red';
//         }



//   document.getElementById(`sub_total`).innerHTML = (document.getElementById(`sub_total`).innerHTML * 1) + price;
  
}

function decreaseValue(id) {
  var value = parseInt(document.getElementById(`${id}[quantity]`).value, 10);
  value = isNaN(value) ? 0 : value;
  value < 1 ? value = 1 : '';
  value--;
  document.getElementById(`${id}[quantity]`).value = value;
  let price =  (document.getElementById(`${id}[price]`).innerHTML * 1);
  document.getElementById(`${id}[total]`).innerHTML = price * value;
//   document.getElementById(`sub_total`).innerHTML = (document.getElementById(`sub_total`).innerHTML * 1) - price;
}
function deleteRaw(id) {
 let raw = document.getElementById(id);
 raw.remove();
}
        </script>
        <div class="row">
            <div class="col-md-6">
               
                    <table class="table text-center">
                        <tbody >
                            <tr>
                                <td>
                                    <strong class="text-muted">Sub Total :</strong>
                                </td>
                                <td id="sub_total">{{$order->grand_total}}</td>
                            </tr>
                            <tr>
    
                                <td>
                                    <strong class="text-muted">Tax :</strong>
                                </td>
                                <td>
                                    {{ $order->orderDetails->sum('tax') }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-muted">Shipping :</strong>
                                </td>
                                <td id="shipping_table">
                                    {{
    
                                    $order->shipping + $order->area_shipping
    
                                    }}
                                    {{-- @@@@@@@@@@@@@@@@@@ --}}
                                    {{-- {{
    
                                    $order->shipping + $order->area_shipping +
                                     $order->orderDetails->shipping_cost
                                    }} --}}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-muted">Discount :</strong>
                                </td>
                                <td id="discount_table">
                                    {{  $order->discount }}
                                </td>
                            </tr>
    
                            <tr>
                                <td>
                                    <strong class="text-muted">Coupon:</strong>
                                </td>
                                <td>
                                    {{ $order->coupon_discount }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong class="text-muted">TOTAL :</strong>
                                </td>
    
                                <td class="text-muted h5" id="total">{{$order->grand_total+$order->shipping+$order->area_shipping-$order->discount}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @php
              $charts = [
    
                 [
                     "name"=> "0-2 kg 120tk",
                     "value" => "120"
                ],
                     [
                     "name"=> "2.1-5 kg 150tk",
                     "value" => "150"
                ],
                     [
                     "name"=> "5.1-8 kg 200tk",
                     "value" => "200"
                ],
                     [
                     "name"=> "8.1-12 kg 250tk",
                     "value" => "250"
                ],
                     [
                     "name"=> "12.1-20 kg 300tk",
                     "value" => "300"
                ],
                    //  [
                    //  "name"=> "20 kg+ Negotiable",
                    //  "value" => "0"
                    //  ]
    
    
                ];
              $areas = [
                [
        "name"=> "Inside Bashundhara 30TK",
        "value" => "30"
    ],
    [
        "name"=> "Inside Dhaka 80TK",
        "value" => "80"
    ],
    [
        "name"=> "Out Side Dhaka ",
        "value" => "0"
    ],
    
    
    
                ];
                    @endphp
    
    
              
            </div>
            <div class="col-md-6 ">
            <div class="">
                <label for="update_shipping">Shipping</label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_shipping">
                    <option value="0" @if ($order->shipping == 0) selected @endif>Please Select</option>
@foreach ($charts as $chart)
<option value="{{$chart["value"]}}" @if ($order->shipping == $chart["value"]) selected @endif>{{$chart["name"]}}</option>
@endforeach



                </select>
            </div>
            <div class="">
                <label for="update_area_shipping">Area</label>
                <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_area_shipping">
                    <option value="0" @if ($order->area_shipping == 0) selected @endif>Please Select</option>
@foreach ($areas as $area)

<option value="{{$area["value"]}}" @if ($order->area_shipping == $area["value"]) selected @endif>{{$area["name"]}}</option>
@endforeach



                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="update_disciont_type">Discount Type</label>
                    <select class="form-control aiz-selectpicker"  data-minimum-results-for-search="Infinity" id="update_disciont_type" name="update_disciont_type">

                        <option value=""  @if ($order->discount_type == "") selected @endif>Select</option>
<option value="fixed"  @if ($order->discount_type == "fixed") selected @endif>fixed</option>
<option value="percent"  @if ($order->discount_type == "percent") selected @endif>percent</option>



                    </select>
                </div>
                <div class="col-md-6"  >

                    <div class="form-group">
                        <label for="update_discount_amount"  > Amount</label>
                        <input name="update_discount_amount"  id="update_discount_amount"  value="{{$order->discount_amount}}" class="form-control"/>
                    </div>

                </div>
            </div>






            

        </div>




        </div>
        <div class="clearfix float-right row">
          
         
           
          
           
            <div class="row" style="margin-top: 1rem" onclick="update()">
                
                <div class="text-center">
                   <button class="btn btn-primary">
                       Update Info
                   </button>
                </div>
            </div>

            {{-- <div class="text-right no-print">
                <a href="{{ route('invoice.download', $order->id) }}" type="button" class="btn btn-icon btn-light"><i class="las la-print"></i></a>
            </div> --}}
        </div>

    </div>
</div>

@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script type="text/javascript">
$('#update_area_shipping').on('change', function(){
    var shipping = $('#update_shipping').val();
    var area_shipping = $('#update_area_shipping').val();
    if(area_shipping == 80|| area_shipping == 30) {
        document.getElementById("update_shipping").value = 0
    }


    });
    $('#update_shipping').on('change', function(){
    var shipping = $('#update_shipping').val();
    var area_shipping = $('#update_area_shipping').val();
    if(area_shipping !== 0) {
        document.getElementById("update_area_shipping").value = 0
    }
    });
let key = {{ $key+1 }}

   


    






    const search = () => {
        let search_key = document.getElementById("search_product").value;
        $.get('{{ route('orders.get_order_details_product') }}', {
            _token:'{{ @csrf_token() }}',
            search_key:search_key
        }, function(data){
            console.log(data.data)
            let productRawString  = ` 
   

   <td> ${key+1} 
    
   </td>
   <td>
                                   
<a href="/products/view/${data.data.variation_id}" target="_blank"><img height="50" src="{{ asset(('/storage/img/' . '${data.data.image}')) }}"></a>
                              
                                 
                                 
                               </td>
   <td>
      
       <strong><a href="/products/view/${data.data.variation_id}" target="_blank" class="text-muted">
        ${data.data.product}
        </a></strong>
      
   
  
    
   </td>
   <td>
   
       @if ($orderDetail->shipping_type != null && $orderDetail->shipping_type == 'home_delivery')
      Home Delivery
   
       @elseif ($orderDetail->shipping_type == 'pickup_point')
   
       @if ($orderDetail->pickup_point != null)
       {{ $orderDetail->pickup_point->getTranslation('name') }} ({{ translate('Pickup Point') }})
       @else
       {{ translate('Pickup Point') }}
       @endif
       @endif
   </td>
   <td class="text-center">
       <span
       onclick="decreaseValue('products[${key+1}]')" 
       class="input-group-btn"><button type="button" class="btn btn-small d-inline quantity-down"><i class="fa fa-minus text-danger"></i></button></span>
   
       <input 
       type="text" 
       data-min="1" 
       class="form-control pos_quantity input_number mousetrap" value="1" name="products-${key+1}-quantity"
       id="products[${key+1}][quantity]"
       >
   
   <p   id="products-${key+1}-info">${data.data.sell_price_inc_tax}-${data.data.variation_id}-${data.data.product_id}-1-e-e-e-e-e-e-e-e</p>
   <p   id="products[${key+1}]-qty" style="display:none;">Quantity Available</p>
   
       <span
       onclick="increaseValue('products[${key+1}]')" 
       class="input-group-btn"><button type="button" class="btn btn-default btn-flat quantity-up"><i class="fa fa-plus text-success"></i></button></span> 
       
     
   
   </td>
   <td class="text-center" >
       <span id="products[${key+1}][price]">${data.data.sell_price_inc_tax}</span>
   </td>
   <td class="text-center" >
   <span  id="products[${key+1}][total]">${data.data.sell_price_inc_tax}</span>
       
   </td>
   
   <td class="text-center"> <button onclick="deleteRaw('products[${key + 1}]')" class="btn btn-danger">X</button> </td>
   
   
   `
   var tempDiv = document.createElement('tr')
tempDiv.innerHTML = productRawString;
tempDiv.setAttribute("id", `products[${key}]`)
document.querySelector(".tbodyproduct").appendChild(tempDiv);
key++
              console.log(data)
        });
    }






const update = () => {
    var order_id = {{ $order->id }};
    var delivery_status = $('#update_delivery_status').val();
    var shipping = $('#update_shipping').val();
        var area_shipping = $('#update_area_shipping').val();
        var   discount_amount =  $('#update_discount_amount').val();
     var   discount_type = $('#update_disciont_type').val();
// update product info
    const products = [];
    var datastring = $("#products").serializeArray();
    let quantityError = false;
    datastring.map(el => {

        let infoId = el.name.split("-")[1];
        let info= document.getElementById(`products-${infoId}-info`).innerHTML;
        const infos = info.split("-");
        console.log(info);

        if(parseInt(infos[4]) < parseInt(el.value)) {
            let errorDom = document.getElementById(`products-${infoId}-info`)
            errorDom.style.color = 'red';
            quantityError = true;
        }


        products.push({
    new_product:parseInt(infos[3]),
    unit_price:parseFloat(infos[0]),
    line_discount_type: 'fixed',
    line_discount_amount:0.00,
    item_tax:0.00,
    tax_id:'',
    sell_line_note:'',
    variation_id:infos[1],
    product_id:infos[2],
    enable_stock:1,
    quantity:el.value,
    unit_price_inc_tax:parseFloat(infos[0]),
    cost:0.0,
    category:1,
    
        })
        console.log(el);
    })

// if(quantityError) {
// return
// }
//         $.ajax({
//             type: "POST",
//             url: "your url.php",
//             data: datastring,
//             success: function(data) {
//                  alert('Data send');
//             }
// });


const updatableData = {
    // unchangable.......
location_id: 9,
price_group: 0,
contact_id: 
256,
pay_term_number: '',
pay_term_type: '',
search_product: '',
sell_price_tax: 'includes',
products:[
  ...products
],


discount_type: 
(discount_type == "percent"?"percentage":"fixed"),
discount_amount: 
discount_amount ,
tax_rate_id: '',
  
tax_calculation_amount: 
 0.00 ,
shipping_details: '',
shipping_charges: 
(shipping * 1) + (area_shipping * 1) ,
final_total: 
350.00,
discount_type_modal: 
'fixed',
discount_amount_modal: 
0.00,
order_tax_modal: '',
shipping_details_modal: '',
shipping_charges_modal: 
0.00,
payment:[
  {
  payment_id:6690,
    amount:430.00,
    method:'cash',
    card_type:'credit',
    card_number:'nothing',
    card_holder_name:'nothing',
    card_holder_name:'nothing',
    card_transaction_number:'nothing',
    card_month:'nothing',
    card_year:'',
    card_security:'nothing',
    cheque_number:'nothing',
    bank_account_number:'nothing',
    transaction_no_1:'',
    transaction_no_2:'',
    transaction_no_3:'',
    note:'',
  }
],
 bank_name:'pk' ,
  sale_note:'',
  staff_note:'',
  change_return :80.00,
   doctor_id:'',
  search_product:'' ,
  assistant_id:'',
  search_product3:'',
  status:'final',     
is_quotation:0


}





if(delivery_status !== "cancelled" || delivery_status !== "return") {
            @if($sell)


            $.post('{{ route('orders.update_order_details',$order->id) }}', {
            _token:'{{ @csrf_token() }}',
            ...updatableData
        }, function(data){
                if(!data.success){
                    toastr.error("something went wrong to update quantity");
                }
        });
















            @endif

 
}














































       
        $.post('{{ route('orders.update_delivery_status') }}', {
            _token:'{{ @csrf_token() }}',
            order_id:order_id,
            status:delivery_status
        }, function(data){

        });

        var payment_status = $('#update_payment_status').val();
        $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:payment_status}, function(data){

        });


      
        var delivery_man = $('#update_delivery_man').val();

        // $.post('{{ route('orders.update_area_shipping') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:area_shipping}, function(data){
        //     document.getElementById("shipping_table").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping)}tk`;
        //     document.getElementById("total").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping) + parseInt(data.grand_total)}tk`;
        //     toastr.success("Data Updated");

        // });
   

        $.post('{{ route('orders.update_shipping') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,shipping:shipping,area_shipping:area_shipping,delivery_man:delivery_man
    ,
    discount_type:discount_type,
    discount_amount:discount_amount

    }, function(data){

            document.getElementById("shipping_table").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping)}tk`;
            document.getElementById("total").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping) + parseInt(data.netTotal) - parseInt(data.discount)}tk`;
            document.getElementById("update_shipping").value = data.shipping
            document.getElementById("update_area_shipping").value = data.area_shipping


            document.getElementById("discount_table").innerHTML =  `${data.discount} tk`


        });




        if(delivery_status == "cancelled" || delivery_status == "return") {
            @if($sell)
            $.post('{{action('SellPosController@destroy', [$sell->id])}}', {_token:'{{ @csrf_token() }}',_method:"DELETE"}, function(data){
});
            @endif

 
}

        if(delivery_status == "delivered") {
            @if(!$sell)
            location.replace(`{{route('create.ecommerce.sell',$order->id)}}`);  
  
  @endif

 
}









        toastr.success("Data Updated");

}
    // $('#update_delivery_status').on('change', function(){

    //     var order_id = {{ $order->id }};
    //     var status = $('#update_delivery_status').val();
    //     $.post('{{ route('orders.update_delivery_status') }}', {
    //         _token:'{{ @csrf_token() }}',
    //         order_id:order_id,
    //         status:status
    //     }, function(data){

    //     });

    // });

    // $('#update_payment_status').on('change', function(){
    //     var order_id = {{ $order->id }};
    //     var status = $('#update_payment_status').val();
    //     $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
    //         AIZ.plugins.notify('success', 'Payment status has been updated');
    //     });
    // });

    // $('#update_shipping').on('change', function(){
    //     var order_id = {{ $order->id }};
    //     var status = $('#update_shipping').val();
    //     $.post('{{ route('orders.update_shipping') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){

    //         document.getElementById("shipping_table").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping)}tk`;
    //         document.getElementById("total").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping) + parseInt(data.grand_total)}tk`;
    //         AIZ.plugins.notify('success', 'Payment status has been updated');
    //     });
    // });

    // $('#update_area_shipping').on('change', function(){
    //     var order_id = {{ $order->id }};
    //     var status = $('#update_area_shipping').val();
    //     $.post('{{ route('orders.update_area_shipping') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){

    //         document.getElementById("shipping_table").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping)}tk`;
    //         document.getElementById("total").innerHTML = `${parseInt(data.shipping) + parseInt(data.area_shipping) + parseInt(data.grand_total)}tk`;
    //         AIZ.plugins.notify('success', 'Payment status has been updated');
    //     });
    // });
</script>
@endsection

@endsection


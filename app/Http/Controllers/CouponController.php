<?php

namespace App\Http\Controllers;

use App\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function index(Request $request) {

        $coupons = Coupon::orderByDesc("id")->paginate(25);

        return view("coupon.index",compact("coupons"));


    }

    public function create (Request $request) {
        
          return view("coupon.create");
    }

    public function store(Request $request) {

$image = "";
$random = Str::random(10);

            //upload document
            if ($request->hasFile('image') && $request->file('image')->isValid()) {

                // dd()
                if ($request->image->getSize() <= config('constants.image_size_limit')) {
                    $new_file_name = time() . '_' . $request->image->getClientOriginalName();
                    $image_path = config('constants.product_img_path');
                    $path = $request->image->storeAs($image_path, $new_file_name);
                    if ($path) {
                        $image = $new_file_name;
                       
                    }
                }
            }





        $coupons = Coupon::insert([
            "code" => $random,
            "description" => $request->description,
            "image" => $image,
            "type" => $request->type,
            "amount" => $request->amount,
            "active_from" => $request->active_from,
            "expire_at" => $request->expire_at,
            "is_valid" => $request->is_valid,
        ]);

        return redirect()->route("coupons.list")->with('message', 'Coupon saved successfully!!!');

    }

    public function edit($id,Request $request) {
        $coupon = Coupon::findOrFail($id);

        return view("coupon.edit",compact("coupon"));
    }
    public function delete($id,Request $request) {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route("coupons.list")->with('message', 'Coupon deleted successfully!!!');
    }
    
    public function update(Request $request) {


        $coupon = Coupon::findOrFail($request->id);

        $image = $coupon->image;

        //upload document
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // dd()
            if ($request->image->getSize() <= config('constants.image_size_limit')) {
                $new_file_name = time() . '_' . $request->image->getClientOriginalName();
                $image_path = config('constants.product_img_path');
                $path = $request->image->storeAs($image_path, $new_file_name);
                if ($path) {
                    $image = $new_file_name;
                   
                }
            }
        }



       
        $coupon->description = $request->description;
        $coupon->image = $image;
        $coupon->type = $request->type;
        $coupon->amount = $request->amount;

        $coupon->active_from = $request->active_from;
        $coupon->expire_at = $request->expire_at;
        $coupon->is_valid = $request->is_valid;
        $coupon->save();
        return redirect()->route("coupons.list")->with('message', 'Coupon updated successfully!!!');
    }
}

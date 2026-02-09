<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{

    // List all coupons
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }


    // Store coupon
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ]);

        Coupon::create([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Coupon created successfully!');
    }


    // Update coupon
    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id,
            'discount_type' => 'required',
            'discount_value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date',
        ]);

        $coupon->update([
            'code' => $request->code,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Coupon updated successfully!');
    }


    // Delete coupon
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['success' => true]);
    }
}

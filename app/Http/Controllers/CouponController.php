<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Coupon;
use Exception;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['coupons'] = Coupon::paginate(10);
        return view('admin.coupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['coupon'] = new Coupon();
        return view('admin.coupon.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => $request->has('coupon')? 'required' : 'required|unique:coupons,name',
            'type' => 'required',
            'target' => 'required',
            'value' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);
        
        try {
            
            $coupon = Coupon::updateOrCreate([
                'id' => Helper::decodeId($request->coupon)
            ], $request->all());

            return redirect()->back()->with('success', $request->has('coupon') ? 'Coupon Updated Successfully' : 'Coupon Created Successfully'); 
        
        } catch (Exception $ex) {
            Helper::throwExeception($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['coupon'] = Coupon::find(Helper::decodeId($id));
        return view('admin.coupon.create', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Coupon::where('id', Helper::decodeId($request->coupon))->delete();
        return redirect()->back()->with('success', 'Coupon Deleted Successfully'); 
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FilterSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filter_id == null) {
            $filterSetting = new FilterSetting();
        } else {
            $filterSetting = FilterSetting::find($request->filter_id);
        }
        // dd($request->filter_id);
        // dd($filterSetting);

        $filterSetting->name = $request->name;
        $filterSetting->user_id = $request->user_id;
        // Check if select_store is not null
        $store_ids = '';
        if ($request->select_store != null) {
            // Convert array to comma-separated string
            $store_ids = implode(',', $request->select_store);
        }
        $user = Auth::user()->id;
        $filterSetting->user_id = $user;

        // Create an associative array with various values
        $value = [
            'id' => $request->id,
            'order_number' => $request->order_number,
            'fullfillment' => $request->fullfillment,
            'store_ids' =>  $store_ids,
            // 'tracking_id' => $request->tracking_id,
            // 'min_amount' => $request->min_amount,
            // 'max_amount' => $request->max_amount,
            // 'product_id' => $request->product_id,
            'date_range' => $request->date_range,
        ];

        // dd(json_encode($value));

        // Assign the array to the 'value' property of $filterSetting
        $filterSetting->value = json_encode($value);

        // Save the $filterSetting object to the database
        // dd($filterSetting);
        if ($request->filter_id == null) {
            $filterSetting->save();
            return back()->with('success', 'Add Successfully!');
        } else {
            $filterSetting->update();
            return back()->with('success', 'Update Successfully!');
        }
        return back()->withInput()->with('error', 'Something Went Wrong');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FilterSetting  $filterSetting
     * @return \Illuminate\Http\Response
     */
    public function show(FilterSetting $filterSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FilterSetting  $filterSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(FilterSetting $filterSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FilterSetting  $filterSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FilterSetting $filterSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FilterSetting  $filterSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy($filterSetting)
    {
        try {
            $filter = FilterSetting::find($filterSetting);
            $filter->delete();
            return back()->with('success', 'Filter Deleted!');
        } catch (Exception $e) {
            return back()->with('error', 'Filter Not Exist');
        }
    }
}

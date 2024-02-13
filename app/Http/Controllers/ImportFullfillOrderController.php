<?php

namespace App\Http\Controllers;

use App\Imports\ImportFullfill;
use App\Models\ImportFullfillOrder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelExcel;

class ImportFullfillOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ImportFullfillOrder::where('fullfill', 0)->paginate(15);
        // dd($orders);
        return view('import-full-fill-order.index', ['orders' => $orders]);
    }
    public function import(Request $request)
    {
        // dd(request()->file('import'));
        $i = Excel::import(new ImportFullfill, request()->file('import'));
        // dd($i);
        return redirect()->back();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImportFullfillOrder  $importFullfillOrder
     * @return \Illuminate\Http\Response
     */
    public function show(ImportFullfillOrder $importFullfillOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ImportFullfillOrder  $importFullfillOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(ImportFullfillOrder $importFullfillOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ImportFullfillOrder  $importFullfillOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImportFullfillOrder $importFullfillOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImportFullfillOrder  $importFullfillOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImportFullfillOrder $importFullfillOrder)
    {
        //
    }
}

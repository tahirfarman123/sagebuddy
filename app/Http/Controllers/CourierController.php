<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!empty(request()->file('image'))) {
            $destinationPath = 'courier/images';
            $extension = request()->file('image')->getClientOriginalExtension();
            $fileName = 'courier/images/' . 'pi-' . time() . rand() . '.' . $extension;
            request()->file('image')->move($destinationPath, $fileName);
            $image = $fileName;
        }

        $courier = Courier::Create([
            'name' => $request->name,
            'image' => $image
        ]);
        return back()->with('success', 'Courier Company Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Courier $courier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Courier $courier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Courier $courier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Courier $courier)
    {
        //
    }
}

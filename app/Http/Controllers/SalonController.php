<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonRequest;
use App\Http\Requests\UpdateSalonRequest;


class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Salon::all();
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
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required'
        ]);
        
        Salon::create($validatedData);
        
        return 'Success';
    }

    /**
     * Display the specified resource.
     */
    public function show(Salon $salon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salon $salon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalonRequest $request, Salon $salon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salon $salon)
    {
        $salon->delete();

        return 'Deleted';
    }
}

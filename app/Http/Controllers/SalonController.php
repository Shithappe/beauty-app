<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Models\Service;
use App\Models\Record;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSalonRequest;
use App\Http\Requests\UpdateSalonRequest;


class SalonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_api()
    {
        return Salon::all();
    }

    public function index()
    {
        return Inertia::render('SelectSalon', [
            'salons' => Salon::where('is_open', true)->get(),
        ]);
    }
    
    public function forAdmin()
    {
        return Inertia::render('Admin', [
            'firstsalons' => Salon::all()
        ]);
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
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required'
        ]);

        $salon->update($validatedData);

        return 'Updated';
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

<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecordRequest;
use App\Http\Requests\UpdateRecordRequest;

use DateTime;
use DatePeriod;
use DateInterval;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Record::all();
    }

    public function getAvailableRecords(int $serviceId, string $date)
    {
        $start = new DateTime('10:00:00');
        $end = new DateTime('16:00:00');
        $interval = new DateInterval('PT30M'); // interval 30 min

        $takenPeriods = Record::where('service_id', '=', $serviceId)->where('date', '=', $date)->get();

        $currentTime = $start;
        $availablePeriods = [];

        while ($currentTime <= $end) {
            $availablePeriods[] = $currentTime->format('H:i');
            $currentTime->add($interval);

            if ($currentTime >= $end){
                break;
            }
        }

        $occupiedTimeSlots = [];
        foreach ($takenPeriods as $occupiedTime) {
            $formattedTime = (new DateTime($occupiedTime["time"]))->format('H:i');
            $occupiedTimeSlots[] = $formattedTime;
        }

        $availablePeriods = array_diff($availablePeriods, $occupiedTimeSlots);
        $availablePeriods = array_values($availablePeriods);

        // return [$availablePeriods, $occupiedTimeSlots];
        return $availablePeriods;
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
        // return $request->all();
        $validatedData = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'salon_id' => 'required',
            'service_id' => 'required'
        ]);

        // return $validatedData;
        
        Record::create($validatedData);
        
        return 'Success';
    }

    /**
     * Display the specified resource.
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecordRequest $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Record $record)
    {
        $record->delete();

        return 'Deleted';
    }
}

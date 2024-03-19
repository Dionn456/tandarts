<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentTreatment;
use App\Models\AppointmentUser;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all(); 
        return response()->json($appointments);
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
        $appointment = new Appointment;
        $appointment->start = date("Y-m-d H:i:s", strtotime(($request->start) ? $request->start : date("Y-m-d H:i:s")));
        $appointment->end = date("Y-m-d H:i:s", strtotime(($request->end) ? $request->end : date("Y-m-d H:i:s")));
        $appointment->description = $request->description;
        $appointment->status_id = 1;
        $appointment->room_id = 1;//$request->room_id;
        $appointment->save(); 

        foreach ($request->treatments as $treatment) {
            $treatment = $treatment["treatment"];

            if ($treatment != null) 
            {
                $aTreatment = new AppointmentTreatment;
                $aTreatment->appointment_id = $appointment->id;
                $aTreatment->treatment_id = $treatment["id"];
                $aTreatment->price = $treatment["price"];
                $aTreatment->save();
            }
        }

        $patient = new AppointmentUser;
        $patient->appointment_id = $appointment->id;
        $patient->user_id = $request->user["id"];
        $patient->role_id = 4;
        $patient->save();

        $dentist = new AppointmentUser;
        $dentist->appointment_id = $appointment->id;
        $dentist->user_id = $request->dentist["id"];
        $dentist->role_id = 2;
        $dentist->save();

        

        $getAssistent = array_filter($request->dentist["users"], function($user) {
            if ($user["role_id"] == 3) return $user; 
        });

        if ($getAssistent != null)
        {
            $assistent = new AppointmentUser;
            $assistent->appointment_id = $appointment->id;
            $assistent->user_id = $getAssistent[0]["link_user_id"];
            $assistent->role_id = 3;
            $assistent->save();
        }
        


        return $appointment;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}

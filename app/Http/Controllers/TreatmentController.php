<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $treatments = Treatment::all(); 
        return response()->json($treatments);
    }

    public function analytics($user_id): JsonResponse
    {
        $treatments = DB::select("SELECT *, 
        COUNT(at.treatment_id) as count_treatments
        FROM treatments as t
        LEFT JOIN (appointment_treatments as at
          INNER JOIN appointment_users as au ON au.appointment_id = at.appointment_id AND au.user_id = ".$user_id." AND au.role_id = 2
        )
        ON t.id = at.treatment_id
        GROUP BY t.id;");

        $treatments2 = DB::select("SELECT *, 
		COUNT(r.rating) as ratings,
        SUM(r.rating = 'goed') as rating_good,
        SUM(r.rating = 'slecht') as rating_bad
        FROM treatments as t
        LEFT JOIN (appointment_treatments as at
          INNER JOIN reviews as r ON r.appointment_id = at.appointment_id
        )
        ON t.id = at.treatment_id
        GROUP BY t.id;");

        return response()->json(["amount" => $treatments, "reviews" => $treatments2]);
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
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function edit(Treatment $treatment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treatment $treatment)
    {
        //
    }
}

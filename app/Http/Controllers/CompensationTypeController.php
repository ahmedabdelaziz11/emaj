<?php

namespace App\Http\Controllers;

use App\Models\CompensationType;
use Illuminate\Http\Request;

class CompensationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $compensationTypes = CompensationType::paginate(30);
        return view('compensation-type.index', compact('compensationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CompensationType::create($request->validate(CompensationType::rules()));
        return redirect()->route('compensation-types.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompensationType  $compensationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $compensation_types = CompensationType::find($request->id);
        $compensation_types->update($request->validate(CompensationType::rules('updated')));
        return redirect()->route('compensation-types.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompensationType  $compensationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompensationType $compensationType)
    {
        //
    }
}

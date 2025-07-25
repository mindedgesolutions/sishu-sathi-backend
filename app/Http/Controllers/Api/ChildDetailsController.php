<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildDetailsRequest;
use App\Models\ChildDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChildDetailsController extends Controller
{
    public function index()
    {
        //
    }

    // --------------------------------------

    public function store(ChildDetailsRequest $request, $childId)
    {
        ChildDetails::create([
            'child_master_id' => $childId,
            'below_18_above_35' => $request->below_18_above_35 ? true : false,
            'medical_condition' => $request->medical_condition ? true : false,
            'take_suppliments' => $request->take_suppliments ? true : false,
            'complications_pregnancy' => $request->complications_pregnancy ? true : false,
            'assisted_delivery' => $request->assisted_delivery ? true : false,
            'hospital_born' => $request->hospital_born ? true : false,
            'before_37' => $request->before_37 ? true : false,
            'less_than_two_and_half' => $request->less_than_two_and_half ? true : false,
            'apgar_below_7' => $request->apgar_below_7 ? true : false,
            'complications_birth' => $request->complications_birth ? true : false,
            'cry_at_birth' => $request->cry_at_birth ? true : false,
            'delay_time' => $request->cry_at_birth ? $request->delay_time : null,
            'nicu_stay' => $request->nicu_stay ? true : false,
            'breastfeeding_within_1' => $request->breastfeeding_within_1 ? true : false,
            'jaundice_other' => $request->jaundice_other ? true : false,
            'hospitalised_year_1' => $request->hospitalised_year_1 ? true : false,
            'seizures' => $request->seizures ? true : false,
        ]);

        return response()->json(['message' => 'success'], Response::HTTP_CREATED);
    }

    // --------------------------------------

    public function update(Request $request, $id, $details)
    {
        ChildDetails::where('child_master_id', $id)->update([
            'below_18_above_35' => $request->below_18_above_35 ? true : false,
            'medical_condition' => $request->medical_condition ? true : false,
            'take_suppliments' => $request->take_suppliments ? true : false,
            'complications_pregnancy' => $request->complications_pregnancy ? true : false,
            'assisted_delivery' => $request->assisted_delivery ? true : false,
            'hospital_born' => $request->hospital_born ? true : false,
            'before_37' => $request->before_37 ? true : false,
            'less_than_two_and_half' => $request->less_than_two_and_half ? true : false,
            'apgar_below_7' => $request->apgar_below_7 ? true : false,
            'complications_birth' => $request->complications_birth ? true : false,
            'cry_at_birth' => $request->cry_at_birth ? true : false,
            'delay_time' => $request->cry_at_birth ? $request->delay_time : null,
            'nicu_stay' => $request->nicu_stay ? true : false,
            'breastfeeding_within_1' => $request->breastfeeding_within_1 ? true : false,
            'jaundice_other' => $request->jaundice_other ? true : false,
            'hospitalised_year_1' => $request->hospitalised_year_1 ? true : false,
            'seizures' => $request->seizures ? true : false,
        ]);

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    // --------------------------------------

    public function destroy($id, $details)
    {
        ChildDetails::where('child_master_id', $id)->delete();

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}

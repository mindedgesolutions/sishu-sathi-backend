<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDetailsRequest;
use App\Http\Resources\UserResource;
use App\Models\UserDetails;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json(['data' => UserResource::make($user)], Response::HTTP_OK);
    }

    // -----------------------------------------

    public function update(UserDetailsRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('file') && $request->file('file')->getSize() > 0) {
                $file = $request->file('file');
                $filename = Str::random(10) . time() . '-' . $file->getClientOriginalName();
                $directory = 'uploads/profile';
                // $fileOriginalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                $filePath = $file->storeAs($directory, $filename, 'public');

                UserDetails::where('user_id', Auth::id())->update([
                    'profile_img' => Storage::url($filePath),
                ]);
            }

            UserDetails::where('user_id', Auth::id())->update([
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

            DB::commit();

            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating user details: ' . $th->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'Failed to update user details'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

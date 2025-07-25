<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\UserDetails;
use Illuminate\Http\Request;
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

    public function update(Request $request)
    {
        $data = UserDetails::where('user_id', Auth::id())->first();

        try {
            DB::beginTransaction();

            if ($request->hasFile('file') && $request->file('file')->getSize() > 0) {
                $file = $request->file('file');
                $filename = Str::random(10) . time() . '-' . $file->getClientOriginalName();
                $directory = 'uploads/profile';

                if ($data->profile_img) {
                    $deletePath = str_replace('/storage', '', $data->profile_img);
                    if (Storage::disk('public')->exists($deletePath)) {
                        Storage::disk('public')->delete($deletePath);
                    }
                }

                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }
                $filePath = $file->storeAs($directory, $filename, 'public');

                UserDetails::where('user_id', Auth::id())->update([
                    'profile_img' => Storage::url($filePath),
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'success'], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error updating user details: ' . $th->getMessage());
            DB::rollBack();
            return response()->json(['message' => 'Failed to update user details'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

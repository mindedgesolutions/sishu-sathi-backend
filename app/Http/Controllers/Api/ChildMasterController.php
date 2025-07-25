<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChildMasterRequest;
use App\Models\ChildMaster;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ChildMasterController extends Controller
{
    public function index()
    {
        // resource includes master + details + records
    }

    // -------------------------------------------

    public function store(ChildMasterRequest $request)
    {
        $data = ChildMaster::create([
            'user_id' => Auth::id(),
            'name' => trim($request->name),
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'gender' => $request->gender,
            'blood_group' => $request->blood_group ?? null,
            'relationship' => $request->relationship ?? null,
            'mobile' => $request->mobile ?? null,
            'weight' => $request->weight ?? null,
        ]);

        if ($request->hasFile('file') && $request->file('file')->getSize() > 0) {
            $file = $request->file('file');
            $filename = Str::random(10) . time() . '-' . $file->getClientOriginalName();
            $directory = 'uploads/children/profile';

            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $filePath = $file->storeAs($directory, $filename, 'public');

            ChildMaster::whereId($data->id)->update([
                'profile_img' => Storage::url($filePath),
            ]);
        }

        return response()->json(['message' => 'success'], Response::HTTP_CREATED);
    }

    // -------------------------------------------

    public function update(ChildMasterRequest $request, $id)
    {
        $data = ChildMaster::findOrFail($id);

        ChildMaster::whereId($id)->update([
            'name' => trim($request->name),
            'dob' => date('Y-m-d', strtotime($request->dob)),
            'gender' => $request->gender,
            'blood_group' => $request->blood_group ?? null,
            'relationship' => $request->relationship ?? null,
            'mobile' => $request->mobile ?? null,
            'weight' => $request->weight ?? null,
        ]);

        if ($request->hasFile('file') && $request->file('file')->getSize() > 0) {
            $file = $request->file('file');
            $filename = Str::random(10) . time() . '-' . $file->getClientOriginalName();
            $directory = 'uploads/children/profile';

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

            ChildMaster::whereId($id)->update([
                'profile_img' => Storage::url($filePath),
            ]);
        }

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }

    // -------------------------------------------

    public function destroy($id)
    {
        $data = ChildMaster::findOrFail($id);

        if ($data->profile_img) {
            $deletePath = str_replace('/storage', '', $data->profile_img);
            if (Storage::disk('public')->exists($deletePath)) {
                Storage::disk('public')->delete($deletePath);
            }
        }
        $data->delete();

        return response()->json(['message' => 'success'], Response::HTTP_OK);
    }
}

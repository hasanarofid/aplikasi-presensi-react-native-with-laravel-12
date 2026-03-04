<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProfileUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'position' => 'nullable|string|max:255',
        ]);

        // Create a profile update request that needs admin approval
        $updateRequest = ProfileUpdate::create([
            'user_id' => $user->id,
            'new_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'position' => $request->position,
            ],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Profile update request submitted and awaiting admin approval',
            'update_request' => $updateRequest,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Incorrect current password'], 422);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Password updated successfuly']);
    }
}

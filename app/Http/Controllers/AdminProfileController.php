<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string',
            'gender' => 'nullable|in:Male,Female,Other',
            'civil_status' => 'nullable|string',
            'citizenship' => 'nullable|string',
            'contact_number' => 'nullable|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'house_street' => 'nullable|string',
            'barangay' => 'nullable|string',
            'city_municipality' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048',
            'valid_id_front' => 'nullable|image|max:2048',
            'valid_id_back' => 'nullable|image|max:2048',
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        if ($request->hasFile('valid_id_front')) {
            if ($user->valid_id_front) {
                Storage::delete($user->valid_id_front);
            }
            $validated['valid_id_front'] = $request->file('valid_id_front')->store('ids', 'public');
        }

        if ($request->hasFile('valid_id_back')) {
            if ($user->valid_id_back) {
                Storage::delete($user->valid_id_back);
            }
            $validated['valid_id_back'] = $request->file('valid_id_back')->store('ids', 'public');
        }

        $user->update($validated);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully!');
    }
}

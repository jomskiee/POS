<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the user profile form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Update the user's profile information.
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $passwordOption = $request->input('password_option', 'keep');

        $updateData = [
            'name' => $request->name,
        ];

        // Update password only if changing password option is selected
        if ($passwordOption === 'change') {
            $updateData['password'] = bcrypt($request->password);
        }

        // Update user data
        $user->update($updateData);

        // Update profile data
        $profileData = [
            'name' => $request->name,
            'address' => $request->address,
        ];

        // Add stall_name for brokers only
        if ($user->isBroker() && $request->has('stall_name')) {
            $profileData['stall_name'] = $request->stall_name;
        }

        $user->updateProfile($profileData);

        // Redirect back to the referring page without modal parameter on success
        $referer = request()->header('referer');
        if ($referer) {
            // Remove modal parameter from referer URL
            $cleanUrl = strtok($referer, '?');
            return redirect()->to($cleanUrl)->with('success', 'Profile updated successfully.');
        }

        // Fallback: redirect to appropriate dashboard based on user role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->route('broker.dashboard')->with('success', 'Profile updated successfully.');
        }
    }
}

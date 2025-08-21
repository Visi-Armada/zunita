<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PublicUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PublicAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.public.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:public_users',
            'password' => 'required|string|min:8|confirmed',
            'ic_number' => 'required|string|max:20|unique:public_users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'occupation' => 'nullable|string|max:100',
            'household_size' => 'nullable|integer|min:1',
            'preferred_language' => 'required|in:malay,english,chinese,tamil',
            'consent_marketing' => 'boolean',
            'consent_data_sharing' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = PublicUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ic_number' => $request->ic_number,
            'phone' => $request->phone,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'household_size' => $request->household_size,
            'preferred_language' => $request->preferred_language,
            'consent_marketing' => $request->consent_marketing ?? false,
            'consent_data_sharing' => $request->consent_data_sharing ?? false,
            'profile_completed' => true,
        ]);

        Auth::guard('public')->login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
    }

    public function showLoginForm()
    {
        return view('auth.public.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('public')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('public')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showProfile()
    {
        $user = Auth::guard('public')->user();
        return view('public.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('public')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'household_size' => 'nullable|integer|min:1',
            'preferred_language' => 'required|in:malay,english,chinese,tamil',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update($validator->validated());

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
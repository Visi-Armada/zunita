<?php

namespace App\Http\Controllers;

use App\Models\PublicUser;
use App\Models\Complaint;
use App\Models\Application;
use App\Models\InitiativeSubmission;
use App\Models\ContributionRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PublicUserController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.public.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('public')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.public.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:public_users',
            'ic_number' => 'required|string|max:20|unique:public_users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:500',
            'postcode' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'household_size' => 'nullable|integer|min:1',
            'preferred_language' => 'required|in:malay,english,chinese,tamil',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Sila periksa semula maklumat yang dimasukkan.');
        }

        try {
            $user = PublicUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'ic_number' => $request->ic_number,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'postcode' => $request->postcode,
                'city' => $request->city,
                'state' => $request->state,
                'occupation' => $request->occupation,
                'household_size' => $request->household_size,
                'preferred_language' => $request->preferred_language,
            ]);

            Auth::guard('public')->login($user);

            // Add success message to session
            session()->flash('success', 'Akaun berjaya dicipta! Selamat datang ke platform YB Dato\' Zunita Begum.');

            // Redirect to dashboard
            return redirect('/dashboard');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Ralat berlaku semasa mendaftar. Sila cuba lagi.');
        }
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::guard('public')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = Auth::guard('public')->user();
        
        // Get statistics
        $stats = [
            'total_submissions' => $user->complaints()->count() +
                                  $user->applications()->count() +
                                  $user->initiatives()->count() +
                                  $user->contributionRequests()->count(),
            'pending_submissions' => $user->complaints()->where('status', 'pending')->count() +
                                   $user->applications()->where('status', 'pending')->count() +
                                   $user->initiatives()->where('status', 'pending')->count() +
                                   $user->contributionRequests()->where('status', 'pending')->count(),
            'approved_submissions' => $user->complaints()->where('status', 'approved')->count() +
                                    $user->applications()->where('status', 'approved')->count() +
                                    $user->initiatives()->where('status', 'approved')->count() +
                                    $user->contributionRequests()->where('status', 'approved')->count(),
            'recent_submissions' => $user->complaints()->where('created_at', '>=', now()->subMonth())->count() +
                                  $user->applications()->where('created_at', '>=', now()->subMonth())->count() +
                                  $user->initiatives()->where('created_at', '>=', now()->subMonth())->count() +
                                  $user->contributionRequests()->where('created_at', '>=', now()->subMonth())->count(),
        ];

        // Get recent submissions across all types
        $recentSubmissions = collect()
            ->merge($user->complaints()->latest()->limit(3)->get()->map(function($item) {
                $item->type = 'complaint';
                $item->title = $item->subject;
                return $item;
            }))
            ->merge($user->applications()->latest()->limit(3)->get()->map(function($item) {
                $item->type = 'application';
                $item->title = ucfirst($item->type) . ' Assistance';
                return $item;
            }))
            ->merge($user->initiatives()->latest()->limit(3)->get()->map(function($item) {
                $item->type = 'initiative';
                $item->title = $item->title;
                return $item;
            }))
            ->merge($user->contributionRequests()->latest()->limit(3)->get()->map(function($item) {
                $item->type = 'contribution';
                $item->title = $item->program_name;
                return $item;
            }))
            ->sortByDesc('created_at')
            ->take(5);

        // Get recent notifications
        $notifications = $user->notifications()->latest()->limit(5)->get();

        return view('public.dashboard', compact('user', 'stats', 'recentSubmissions', 'notifications'));
    }

    public function profile()
    {
        $user = Auth::guard('public')->user();
        return view('public.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::guard('public')->user();

        $validated = $request->validate([
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

        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function notifications()
    {
        $user = Auth::guard('public')->user();
        $notifications = $user->notifications()->latest()->paginate(20);
        
        return view('public.notifications', compact('notifications'));
    }

    public function markNotificationAsRead(UserNotification $notification)
    {
        $notification->markAsRead();
        return redirect()->back();
    }

    public function mySubmissions()
    {
        $user = Auth::guard('public')->user();
        
        $complaints = $user->complaints()->latest()->paginate(10);
        $applications = $user->applications()->latest()->paginate(10);
        $initiatives = $user->initiatives()->latest()->paginate(10);
        $contributions = $user->contributionRequests()->latest()->paginate(10);

        return view('public.submissions', compact('complaints', 'applications', 'initiatives', 'contributions'));
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.public.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = PublicUser::where('email', $request->email)->first();

        if ($user) {
            // Create password reset token
            $token = \Illuminate\Support\Str::random(60);
            
            // Store token in password_resets table
            \Illuminate\Support\Facades\DB::table('password_resets')->updateOrInsert(
                ['email' => $user->email],
                [
                    'email' => $user->email,
                    'token' => \Illuminate\Support\Facades\Hash::make($token),
                    'created_at' => now(),
                ]
            );

            // Send password reset email
            $user->notify(new \App\Notifications\PublicUserPasswordReset($token));
        }

        // Always return success message for security (don't reveal if email exists)
        return back()->with('status', 'Jika alamat e-mel wujud dalam sistem kami, pautan set semula kata laluan akan dihantar.');
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.public.reset-password', ['token' => $token]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the password reset record
        $passwordReset = \Illuminate\Support\Facades\DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Alamat e-mel tidak dijumpai.']);
        }

        // Check if token is valid and not expired (24 hours)
        if (!\Illuminate\Support\Facades\Hash::check($request->token, $passwordReset->token)) {
            return back()->withErrors(['token' => 'Token set semula kata laluan tidak sah.']);
        }

        if (abs(now()->diffInHours($passwordReset->created_at)) > 24) {
            return back()->withErrors(['token' => 'Token set semula kata laluan telah tamat tempoh.']);
        }

        // Find the user and update password
        $user = PublicUser::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Pengguna tidak dijumpai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the password reset record
        \Illuminate\Support\Facades\DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect()->route('public.login')
            ->with('success', 'Kata laluan anda telah berjaya ditetapkan semula. Anda boleh log masuk sekarang.');
    }
}
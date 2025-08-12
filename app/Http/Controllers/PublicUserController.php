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

class PublicUserController extends Controller
{
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
}
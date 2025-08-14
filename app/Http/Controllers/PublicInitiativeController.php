<?php

namespace App\Http\Controllers;

use App\Models\Initiative;
use App\Models\InitiativeApplication;
use App\Models\PublicUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PublicInitiativeController extends Controller
{
    /**
     * Display a listing of active initiatives
     */
    public function index(Request $request)
    {
        $query = Initiative::active()
            ->with(['media'])
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Filter by search term
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $initiatives = $query->paginate(12);

        $categories = [
            'education' => 'Education',
            'healthcare' => 'Healthcare',
            'infrastructure' => 'Infrastructure',
            'social_welfare' => 'Social Welfare',
            'economic_development' => 'Economic Development',
            'environment' => 'Environment',
            'youth' => 'Youth Programs',
            'women' => 'Women Empowerment',
            'elderly' => 'Elderly Care',
            'disability' => 'Disability Support',
            'other' => 'Other',
        ];

        return view('public.initiatives.index', compact('initiatives', 'categories'));
    }

    /**
     * Display the specified initiative
     */
    public function show($slug)
    {
        $initiative = Initiative::where('slug', $slug)
            ->with(['media', 'applications'])
            ->firstOrFail();

        // Check if user can apply
        $canApply = $initiative->is_open_for_applications;
        
        // Check if user has already applied
        $hasApplied = false;
        if (Auth::guard('public')->check()) {
            $hasApplied = $initiative->applications()
                ->where('public_user_id', Auth::guard('public')->id())
                ->exists();
        }

        // Get related initiatives
        $relatedInitiatives = Initiative::active()
            ->where('category', $initiative->category)
            ->where('id', '!=', $initiative->id)
            ->limit(3)
            ->get();

        return view('public.initiatives.show', compact('initiative', 'canApply', 'hasApplied', 'relatedInitiatives'));
    }

    /**
     * Show the application form for an initiative
     */
    public function apply($slug)
    {
        $initiative = Initiative::where('slug', $slug)->firstOrFail();

        if (!$initiative->is_open_for_applications) {
            return redirect()->route('initiatives.show', $slug)
                ->with('error', 'Applications for this initiative are currently closed.');
        }

        // Check if user is authenticated
        if (!Auth::guard('public')->check()) {
            return redirect()->route('public.login')
                ->with('error', 'Please log in to apply for this initiative.');
        }

        // Check if user has already applied
        $existingApplication = $initiative->applications()
            ->where('public_user_id', Auth::guard('public')->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('initiatives.show', $slug)
                ->with('error', 'You have already applied for this initiative.');
        }

        return view('public.initiatives.apply', compact('initiative'));
    }

    /**
     * Store the application
     */
    public function storeApplication(Request $request, $slug)
    {
        $initiative = Initiative::where('slug', $slug)->firstOrFail();

        if (!$initiative->is_open_for_applications) {
            return redirect()->route('initiatives.show', $slug)
                ->with('error', 'Applications for this initiative are currently closed.');
        }

        if (!Auth::guard('public')->check()) {
            return redirect()->route('public.login')
                ->with('error', 'Please log in to apply for this initiative.');
        }

        // Check if user has already applied
        $existingApplication = $initiative->applications()
            ->where('public_user_id', Auth::guard('public')->id())
            ->first();

        if ($existingApplication) {
            return redirect()->route('initiatives.show', $slug)
                ->with('error', 'You have already applied for this initiative.');
        }

        // Validate application data based on initiative form configuration
        $validationRules = $this->getValidationRules($initiative);
        $validatedData = $request->validate($validationRules);

        try {
            $application = InitiativeApplication::create([
                'initiative_id' => $initiative->id,
                'public_user_id' => Auth::guard('public')->id(),
                'status' => 'pending',
                'application_data' => $validatedData,
                'submitted_at' => now(),
                'contact_preference' => $request->contact_preference ?? 'email',
                'is_urgent' => $request->has('is_urgent'),
                'priority_score' => $request->priority_score ?? 3,
            ]);

            // Increment initiative application count
            $initiative->incrementApplications();

            // Send notification to admin
            $this->sendApplicationNotification($application);

            return redirect()->route('public.dashboard')
                ->with('success', 'Your application has been submitted successfully. We will review it and contact you soon.');

        } catch (\Exception $e) {
            Log::error('Failed to submit application: ' . $e->getMessage());
            return back()->with('error', 'Failed to submit application. Please try again.');
        }
    }

    /**
     * Get validation rules based on initiative form configuration
     */
    private function getValidationRules(Initiative $initiative): array
    {
        $rules = [
            'contact_preference' => 'required|in:email,phone,sms',
            'priority_score' => 'nullable|integer|between:1,5',
        ];

        $formFields = $initiative->application_form_data ?? [];

        foreach ($formFields as $fieldName => $fieldType) {
            $fieldRules = 'required';

            switch ($fieldType) {
                case 'email':
                    $fieldRules .= '|email';
                    break;
                case 'phone':
                    $fieldRules .= '|regex:/^[0-9+\-\s()]+$/';
                    break;
                case 'number':
                    $fieldRules .= '|numeric';
                    break;
                case 'date':
                    $fieldRules .= '|date';
                    break;
                case 'file':
                    $fieldRules = 'nullable|file|max:10240'; // 10MB max
                    break;
            }

            $rules[$fieldName] = $fieldRules;
        }

        return $rules;
    }

    /**
     * Send notification to admin about new application
     */
    private function sendApplicationNotification(InitiativeApplication $application)
    {
        // This would integrate with the notification service
        // For now, we'll just log it
        Log::info("New application submitted: {$application->application_number} for initiative: {$application->initiative->title}");
    }

    /**
     * Display user's applications
     */
    public function myApplications()
    {
        if (!Auth::guard('public')->check()) {
            return redirect()->route('public.login');
        }

        $applications = InitiativeApplication::where('public_user_id', Auth::guard('public')->id())
            ->with(['initiative'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.initiatives.my-applications', compact('applications'));
    }

    /**
     * Show application details
     */
    public function showApplication($id)
    {
        if (!Auth::guard('public')->check()) {
            return redirect()->route('public.login');
        }

        $application = InitiativeApplication::where('id', $id)
            ->where('public_user_id', Auth::guard('public')->id())
            ->with(['initiative'])
            ->firstOrFail();

        return view('public.initiatives.application-details', compact('application'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Application;
use App\Models\InitiativeSubmission;
use App\Models\ContributionRequest;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    // Complaint Forms
    public function showComplaintForm()
    {
        return view('public.forms.complaint');
    }

    public function storeComplaint(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'subject' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $complaint = new Complaint([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending'
        ]);

        $complaint->save();

        // Handle file uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('complaints/' . $complaint->id, 'public');
                $documents[] = $path;
            }
            $complaint->documents = json_encode($documents);
            $complaint->save();
        }

        // Create notification
        UserNotification::create([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => 'complaint_submitted',
            'message' => 'Your complaint "' . $validated['subject'] . '" has been submitted successfully.',
            'related_id' => $complaint->id,
            'related_type' => 'complaint'
        ]);

        return redirect()->route('public.dashboard')->with('success', 'Complaint submitted successfully!');
    }

    // Application Forms
    public function showApplicationForm()
    {
        return view('public.forms.application');
    }

    public function storeApplication(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'amount_requested' => 'required|numeric|min:0',
            'purpose' => 'required|string',
            'current_situation' => 'required|string',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $application = new Application([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => $validated['type'],
            'amount_requested' => $validated['amount_requested'],
            'purpose' => $validated['purpose'],
            'current_situation' => $validated['current_situation'],
            'status' => 'pending'
        ]);

        $application->save();

        // Handle file uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('applications/' . $application->id, 'public');
                $documents[] = $path;
            }
            $application->documents = json_encode($documents);
            $application->save();
        }

        // Create notification
        UserNotification::create([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => 'application_submitted',
            'message' => 'Your application for ' . $validated['type'] . ' assistance has been submitted.',
            'related_id' => $application->id,
            'related_type' => 'application'
        ]);

        return redirect()->route('public.dashboard')->with('success', 'Application submitted successfully!');
    }

    // Initiative Forms
    public function showInitiativeForm()
    {
        return view('public.forms.initiative');
    }

    public function storeInitiative(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'expected_benefits' => 'required|string',
            'estimated_budget' => 'required|numeric|min:0',
            'timeline' => 'required|string|max:255',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $initiative = new InitiativeSubmission([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'expected_benefits' => $validated['expected_benefits'],
            'estimated_budget' => $validated['estimated_budget'],
            'timeline' => $validated['timeline'],
            'status' => 'pending'
        ]);

        $initiative->save();

        // Handle file uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('initiatives/' . $initiative->id, 'public');
                $documents[] = $path;
            }
            $initiative->documents = json_encode($documents);
            $initiative->save();
        }

        // Create notification
        UserNotification::create([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => 'initiative_submitted',
            'message' => 'Your initiative "' . $validated['title'] . '" has been submitted for review.',
            'related_id' => $initiative->id,
            'related_type' => 'initiative'
        ]);

        return redirect()->route('public.dashboard')->with('success', 'Initiative proposal submitted successfully!');
    }

    // Contribution Request Forms
    public function showContributionRequestForm()
    {
        return view('public.forms.contribution-request');
    }

    public function storeContributionRequest(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|max:50',
            'program_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'amount_requested' => 'required|numeric|min:0',
            'expected_attendance' => 'required|integer|min:1',
            'description' => 'required|string',
            'budget_breakdown' => 'required|string',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
        ]);

        $contributionRequest = new ContributionRequest([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => $validated['type'],
            'program_name' => $validated['program_name'],
            'location' => $validated['location'],
            'date' => $validated['date'],
            'amount_requested' => $validated['amount_requested'],
            'expected_attendance' => $validated['expected_attendance'],
            'description' => $validated['description'],
            'budget_breakdown' => $validated['budget_breakdown'],
            'status' => 'pending'
        ]);

        $contributionRequest->save();

        // Handle file uploads
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $file) {
                $path = $file->store('contribution-requests/' . $contributionRequest->id, 'public');
                $documents[] = $path;
            }
            $contributionRequest->documents = json_encode($documents);
            $contributionRequest->save();
        }

        // Create notification
        UserNotification::create([
            'public_user_id' => Auth::guard('public')->id(),
            'type' => 'contribution_request_submitted',
            'message' => 'Your funding request for "' . $validated['program_name'] . '" has been submitted.',
            'related_id' => $contributionRequest->id,
            'related_type' => 'contribution_request'
        ]);

        return redirect()->route('public.dashboard')->with('success', 'Funding request submitted successfully!');
    }
}
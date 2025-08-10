<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contributions = Contribution::with(['creator', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('contributions.index', compact('contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('contributions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        // Validate request
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_ic' => 'required|string|max:20',
            'recipient_phone' => 'required|string|max:20',
            'recipient_address' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'contribution_type' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'payment_method' => 'required|in:cash,cheque',
            'cheque_number' => 'nullable|string|max:50',
            'contribution_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'documents' => 'nullable|array',
            'documents.*' => 'file|max:10240' // 10MB max
        ]);

        try {
            // Generate voucher number
            $validated['voucher_number'] = Contribution::generateVoucherNumber();
            $validated['created_by'] = auth()->id();
            $validated['status'] = 'pending';

            // Handle document uploads
            if ($request->hasFile('documents')) {
                $documents = [];
                foreach ($request->file('documents') as $file) {
                    $path = $file->store('contributions/documents', 'private');
                    $documents[] = $path;
                }
                $validated['documents'] = $documents;
            }

            // Create contribution
            $contribution = Contribution::create($validated);

            // Log the action
            AuditService::logDataChange(
                'create',
                'Contribution',
                $contribution->id,
                $contribution->voucher_number,
                null,
                $contribution->getAnonymizedData(),
                array_keys($validated)
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribution created successfully',
                'data' => $contribution->getAnonymizedData()
            ], 201);

        } catch (\Exception $e) {
            // Log the error
            AuditService::logSecurityEvent(
                'error',
                'medium',
                'Failed to create contribution: ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Failed to create contribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contribution $contribution): View
    {
        // Check if user has permission to view this contribution
        if (!auth()->user()->can('view', $contribution)) {
            abort(403);
        }

        return view('contributions.show', compact('contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribution $contribution): View
    {
        // Check if user has permission to edit this contribution
        if (!auth()->user()->can('update', $contribution)) {
            abort(403);
        }

        return view('contributions.edit', compact('contribution'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contribution $contribution): JsonResponse
    {
        // Check if user has permission to update this contribution
        if (!auth()->user()->can('update', $contribution)) {
            abort(403);
        }

        // Store old values for audit
        $oldValues = $contribution->getAnonymizedData();

        // Validate request
        $validated = $request->validate([
            'recipient_name' => 'sometimes|required|string|max:255',
            'recipient_ic' => 'sometimes|required|string|max:20',
            'recipient_phone' => 'sometimes|required|string|max:20',
            'recipient_address' => 'sometimes|required|string',
            'amount' => 'sometimes|required|numeric|min:0',
            'contribution_type' => 'sometimes|required|string|max:100',
            'category' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|required|string',
            'payment_method' => 'sometimes|required|in:cash,cheque',
            'cheque_number' => 'nullable|string|max:50',
            'contribution_date' => 'sometimes|required|date',
            'location' => 'nullable|string|max:255',
            'admin_notes' => 'nullable|string'
        ]);

        try {
            // Update contribution
            $contribution->update($validated);

            // Log the action
            AuditService::logDataChange(
                'update',
                'Contribution',
                $contribution->id,
                $contribution->voucher_number,
                $oldValues,
                $contribution->getAnonymizedData(),
                array_keys($validated)
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribution updated successfully',
                'data' => $contribution->getAnonymizedData()
            ]);

        } catch (\Exception $e) {
            // Log the error
            AuditService::logSecurityEvent(
                'error',
                'medium',
                'Failed to update contribution: ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Failed to update contribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribution $contribution): JsonResponse
    {
        // Check if user has permission to delete this contribution
        if (!auth()->user()->can('delete', $contribution)) {
            abort(403);
        }

        try {
            // Store old values for audit
            $oldValues = $contribution->getAnonymizedData();

            // Soft delete the contribution
            $contribution->delete();

            // Log the action
            AuditService::logDataChange(
                'delete',
                'Contribution',
                $contribution->id,
                $contribution->voucher_number,
                $oldValues,
                null,
                ['deleted_at']
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribution deleted successfully'
            ]);

        } catch (\Exception $e) {
            // Log the error
            AuditService::logSecurityEvent(
                'error',
                'high',
                'Failed to delete contribution: ' . $e->getMessage()
            );

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete contribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Approve a contribution
     */
    public function approve(Contribution $contribution): JsonResponse
    {
        // Check if user has permission to approve contributions
        if (!auth()->user()->can('approve', Contribution::class)) {
            abort(403);
        }

        try {
            $contribution->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            // Log the action
            AuditService::logDataChange(
                'approve',
                'Contribution',
                $contribution->id,
                $contribution->voucher_number,
                ['status' => 'pending'],
                ['status' => 'approved'],
                ['status', 'approved_by', 'approved_at']
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribution approved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve contribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a contribution
     */
    public function reject(Request $request, Contribution $contribution): JsonResponse
    {
        // Check if user has permission to reject contributions
        if (!auth()->user()->can('approve', Contribution::class)) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'required|string'
        ]);

        try {
            $contribution->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            // Log the action
            AuditService::logDataChange(
                'reject',
                'Contribution',
                $contribution->id,
                $contribution->voucher_number,
                ['status' => 'pending'],
                ['status' => 'rejected'],
                ['status', 'admin_notes', 'approved_by', 'approved_at']
            );

            return response()->json([
                'success' => true,
                'message' => 'Contribution rejected successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject contribution',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get public statistics (anonymized)
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_contributions' => Contribution::approved()->count(),
            'total_amount' => Contribution::approved()->sum('amount'),
            'by_category' => Contribution::approved()
                ->selectRaw('category, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('category')
                ->get(),
            'by_month' => Contribution::approved()
                ->selectRaw('DATE_FORMAT(contribution_date, "%Y-%m") as month, COUNT(*) as count, SUM(amount) as total')
                ->groupBy('month')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}

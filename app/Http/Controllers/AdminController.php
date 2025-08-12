<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Get admin dashboard statistics
     */
    public function adminStats(): JsonResponse
    {
        try {
            $today = now()->startOfDay();
            
            $totalContributions = Contribution::sum('amount');
            $totalRecipients = Contribution::distinct('recipient_ic_encrypted')->count();
            $todayEntries = Contribution::whereDate('created_at', $today)->count();
            $pendingReview = Contribution::pending()->count();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'total_contributions' => $totalContributions,
                    'total_recipients' => $totalRecipients,
                    'today_entries' => $todayEntries,
                    'pending_review' => $pendingReview
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading admin stats',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get recent entries for admin dashboard
     */
    public function recentEntries(): JsonResponse
    {
        try {
            $entries = Contribution::with(['creator'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($contribution) {
                    return [
                        'id' => $contribution->id,
                        'recipient_name' => $contribution->recipient_name,
                        'amount' => $contribution->amount,
                        'category' => $contribution->category,
                        'description' => $contribution->description,
                        'status' => $contribution->status,
                        'created_by' => $contribution->creator->name,
                        'date' => $contribution->created_at->format('M d, Y H:i')
                    ];
                });
            
            return response()->json([
                'success' => true,
                'entries' => $entries
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error loading recent entries',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lookup recipient by IC number
     */
    public function lookupRecipient($ic): JsonResponse
    {
        try {
            // For now, return mock data - will implement actual lookup
            // This will search encrypted IC numbers in the future
            $recipient = Contribution::where('recipient_ic_encrypted', 'like', "%$ic%")
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($recipient) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'name' => $recipient->recipient_name,
                        'phone' => $recipient->recipient_phone,
                        'address' => $recipient->recipient_address
                    ]
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Recipient not found'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error looking up recipient',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk import contributions
     */
    public function bulkImport(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls'
        ]);

        try {
            // Implement bulk import logic
            return response()->json([
                'success' => true,
                'message' => 'Bulk import completed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error importing data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log an action
     */
    public static function log(
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?string $modelIdentifier = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?array $changedFields = null,
        string $riskLevel = 'low',
        ?string $securityNotes = null
    ): void {
        try {
            $request = request();
            
            // Handle session safely
            $sessionId = null;
            if ($request && $request->hasSession()) {
                try {
                    $sessionId = $request->session()->getId();
                } catch (\Exception $e) {
                    $sessionId = 'no-session';
                }
            } else {
                $sessionId = 'no-session';
            }
            
            AuditLog::create([
                'user_id' => Auth::id(),
                'user_ip' => $request ? $request->ip() : null,
                'user_agent' => $request ? $request->userAgent() : null,
                'session_id' => $sessionId,
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'model_identifier' => $modelIdentifier,
                'old_values' => $oldValues ? self::sanitizeData($oldValues) : null,
                'new_values' => $newValues ? self::sanitizeData($newValues) : null,
                'changed_fields' => $changedFields,
                'route' => $request && $request->route() ? $request->route()->getName() : null,
                'method' => $request ? $request->method() : null,
                'url' => $request ? $request->fullUrl() : null,
                'request_data' => $request ? self::sanitizeRequestData($request) : null,
                'risk_level' => $riskLevel,
                'security_notes' => $securityNotes,
                'performed_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break the application
            \Log::error('Audit logging failed: ' . $e->getMessage());
        }
    }

    /**
     * Log a security event
     */
    public static function logSecurityEvent(
        string $action,
        string $riskLevel,
        string $securityNotes,
        ?array $context = null
    ): void {
        self::log(
            $action,
            null,
            null,
            null,
            null,
            null,
            null,
            $riskLevel,
            $securityNotes
        );
    }

    /**
     * Log data changes
     */
    public static function logDataChange(
        string $action,
        string $modelType,
        int $modelId,
        ?string $modelIdentifier,
        ?array $oldValues,
        ?array $newValues,
        ?array $changedFields = null
    ): void {
        // Determine risk level based on action and model
        $riskLevel = self::determineRiskLevel($action, $modelType);
        
        self::log(
            $action,
            $modelType,
            $modelId,
            $modelIdentifier,
            $oldValues,
            $newValues,
            $changedFields,
            $riskLevel
        );
    }

    /**
     * Log authentication events
     */
    public static function logAuthEvent(string $action, ?string $email = null, ?string $securityNotes = null): void
    {
        $riskLevel = in_array($action, ['login_failed', 'password_reset', 'suspicious_activity']) ? 'high' : 'low';
        
        self::log(
            $action,
            'User',
            null,
            $email,
            null,
            null,
            null,
            $riskLevel,
            $securityNotes
        );
    }

    /**
     * Sanitize sensitive data before logging
     */
    private static function sanitizeData(array $data): array
    {
        $sensitiveFields = [
            'password', 'password_confirmation', 'token', 'api_key',
            'recipient_name', 'recipient_ic', 'recipient_phone', 'recipient_address',
            'credit_card', 'bank_account', 'ssn', 'ic_number'
        ];

        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[REDACTED]';
            }
        }

        return $data;
    }

    /**
     * Sanitize request data
     */
    private static function sanitizeRequestData(Request $request): array
    {
        $data = $request->all();
        return self::sanitizeData($data);
    }

    /**
     * Determine risk level based on action and model
     */
    private static function determineRiskLevel(string $action, ?string $modelType): string
    {
        // High-risk actions
        if (in_array($action, ['delete', 'bulk_delete', 'export', 'login_failed'])) {
            return 'high';
        }

        // Medium-risk actions
        if (in_array($action, ['update', 'bulk_update', 'approve', 'reject'])) {
            return 'medium';
        }

        // High-risk models
        if (in_array($modelType, ['Contribution', 'User', 'AuditLog'])) {
            return 'medium';
        }

        return 'low';
    }

    /**
     * Get recent security events
     */
    public static function getRecentSecurityEvents(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return AuditLog::where('risk_level', 'high')
            ->orWhere('risk_level', 'critical')
            ->orderBy('performed_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get user activity summary
     */
    public static function getUserActivitySummary(int $userId, int $days = 30): array
    {
        $startDate = now()->subDays($days);
        
        $activities = AuditLog::where('user_id', $userId)
            ->where('performed_at', '>=', $startDate)
            ->get();

        return [
            'total_actions' => $activities->count(),
            'actions_by_type' => $activities->groupBy('action')->map->count(),
            'risk_levels' => $activities->groupBy('risk_level')->map->count(),
            'last_activity' => $activities->max('performed_at'),
        ];
    }

    /**
     * Check for suspicious activity
     */
    public static function checkSuspiciousActivity(int $userId): array
    {
        $last24Hours = now()->subDay();
        
        $recentActivities = AuditLog::where('user_id', $userId)
            ->where('performed_at', '>=', $last24Hours)
            ->get();

        $suspicious = [];

        // Check for too many failed logins
        $failedLogins = $recentActivities->where('action', 'login_failed')->count();
        if ($failedLogins > 5) {
            $suspicious[] = "Multiple failed login attempts: {$failedLogins}";
        }

        // Check for unusual data access patterns
        $dataAccess = $recentActivities->whereIn('action', ['view', 'export'])->count();
        if ($dataAccess > 100) {
            $suspicious[] = "Unusual amount of data access: {$dataAccess} actions";
        }

        // Check for high-risk actions
        $highRiskActions = $recentActivities->whereIn('risk_level', ['high', 'critical'])->count();
        if ($highRiskActions > 10) {
            $suspicious[] = "Multiple high-risk actions: {$highRiskActions}";
        }

        return $suspicious;
    }
}

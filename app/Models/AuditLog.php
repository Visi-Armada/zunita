<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_ip',
        'user_agent',
        'session_id',
        'action',
        'model_type',
        'model_id',
        'model_identifier',
        'old_values',
        'new_values',
        'changed_fields',
        'route',
        'method',
        'url',
        'request_data',
        'risk_level',
        'security_notes',
        'performed_at'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changed_fields' => 'array',
        'request_data' => 'array',
        'performed_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopeByRiskLevel($query, $riskLevel)
    {
        return $query->where('risk_level', $riskLevel);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeByModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('performed_at', '>=', now()->subDays($days));
    }

    public function scopeSecurityEvents($query)
    {
        return $query->whereIn('risk_level', ['high', 'critical']);
    }

    /**
     * Get formatted action description
     */
    public function getActionDescriptionAttribute(): string
    {
        $descriptions = [
            'create' => 'Created',
            'update' => 'Updated',
            'delete' => 'Deleted',
            'login' => 'Logged in',
            'logout' => 'Logged out',
            'login_failed' => 'Failed login attempt',
            'password_reset' => 'Password reset',
            'export' => 'Exported data',
            'import' => 'Imported data',
            'approve' => 'Approved',
            'reject' => 'Rejected',
            'view' => 'Viewed',
            'download' => 'Downloaded',
            'bulk_update' => 'Bulk updated',
            'bulk_delete' => 'Bulk deleted',
        ];

        return $descriptions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get risk level color for UI
     */
    public function getRiskLevelColorAttribute(): string
    {
        return match($this->risk_level) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get formatted timestamp
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->performed_at->format('d M Y, H:i:s');
    }

    /**
     * Get user-friendly model name
     */
    public function getModelNameAttribute(): string
    {
        if (!$this->model_type) {
            return 'System';
        }

        $names = [
            'Contribution' => 'Contribution',
            'User' => 'User',
            'AuditLog' => 'Audit Log',
            'Initiative' => 'Initiative',
            'Application' => 'Application',
        ];

        return $names[$this->model_type] ?? $this->model_type;
    }
}

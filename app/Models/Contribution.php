<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\EncryptionService;

class Contribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recipient_name',
        'recipient_ic',
        'recipient_phone',
        'recipient_address',
        'recipient_name_encrypted',
        'recipient_ic_encrypted',
        'recipient_phone_encrypted',
        'recipient_address_encrypted',
        'amount',
        'contribution_type',
        'category',
        'description',
        'payment_method',
        'cheque_number',
        'contribution_date',
        'voucher_number',
        'location',
        'documents',
        'status',
        'admin_notes',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'contribution_date' => 'date',
        'approved_at' => 'datetime',
        'documents' => 'array',
        'amount' => 'decimal:2'
    ];

    protected $hidden = [
        'recipient_name_encrypted',
        'recipient_ic_encrypted',
        'recipient_phone_encrypted',
        'recipient_address_encrypted'
    ];

    /**
     * Boot the model and add encryption/decryption
     */
    protected static function boot()
    {
        parent::boot();

        // Encrypt sensitive data before saving
        static::saving(function ($contribution) {
            $contribution->encryptSensitiveData();
        });

        // Decrypt sensitive data after retrieving
        static::retrieved(function ($contribution) {
            $contribution->decryptSensitiveData();
        });
    }

    /**
     * Encrypt sensitive data before saving
     */
    public function encryptSensitiveData()
    {
        $sensitiveFields = ['recipient_name', 'recipient_ic', 'recipient_phone', 'recipient_address'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($this->attributes[$field])) {
                $this->attributes[$field . '_encrypted'] = EncryptionService::encrypt($this->attributes[$field]);
                unset($this->attributes[$field]);
            }
        }
    }

    /**
     * Decrypt sensitive data after retrieving
     */
    public function decryptSensitiveData()
    {
        $sensitiveFields = ['recipient_name', 'recipient_ic', 'recipient_phone', 'recipient_address'];
        
        foreach ($sensitiveFields as $field) {
            $encryptedField = $field . '_encrypted';
            if (isset($this->attributes[$encryptedField])) {
                $this->attributes[$field] = EncryptionService::decrypt($this->attributes[$encryptedField]);
            }
        }
    }

    /**
     * Get recipient name (decrypted)
     */
    public function getRecipientNameAttribute()
    {
        if (isset($this->attributes['recipient_name'])) {
            return $this->attributes['recipient_name'];
        }
        
        if (isset($this->attributes['recipient_name_encrypted'])) {
            return EncryptionService::decrypt($this->attributes['recipient_name_encrypted']);
        }
        
        return null;
    }

    /**
     * Set recipient name (will be encrypted)
     */
    public function setRecipientNameAttribute($value)
    {
        $this->attributes['recipient_name'] = $value;
    }

    /**
     * Get recipient IC (decrypted)
     */
    public function getRecipientIcAttribute()
    {
        if (isset($this->attributes['recipient_ic'])) {
            return $this->attributes['recipient_ic'];
        }
        
        if (isset($this->attributes['recipient_ic_encrypted'])) {
            return EncryptionService::decrypt($this->attributes['recipient_ic_encrypted']);
        }
        
        return null;
    }

    /**
     * Set recipient IC (will be encrypted)
     */
    public function setRecipientIcAttribute($value)
    {
        $this->attributes['recipient_ic'] = $value;
    }

    /**
     * Get recipient phone (decrypted)
     */
    public function getRecipientPhoneAttribute()
    {
        if (isset($this->attributes['recipient_phone'])) {
            return $this->attributes['recipient_phone'];
        }
        
        if (isset($this->attributes['recipient_phone_encrypted'])) {
            return EncryptionService::decrypt($this->attributes['recipient_phone_encrypted']);
        }
        
        return null;
    }

    /**
     * Set recipient phone (will be encrypted)
     */
    public function setRecipientPhoneAttribute($value)
    {
        $this->attributes['recipient_phone'] = $value;
    }

    /**
     * Get recipient address (decrypted)
     */
    public function getRecipientAddressAttribute()
    {
        if (isset($this->attributes['recipient_address'])) {
            return $this->attributes['recipient_address'];
        }
        
        if (isset($this->attributes['recipient_address_encrypted'])) {
            return EncryptionService::decrypt($this->attributes['recipient_address_encrypted']);
        }
        
        return null;
    }

    /**
     * Set recipient address (will be encrypted)
     */
    public function setRecipientAddressAttribute($value)
    {
        $this->attributes['recipient_address'] = $value;
    }

    /**
     * Generate unique voucher number
     */
    public static function generateVoucherNumber(): string
    {
        $prefix = 'ZB';
        $year = date('Y');
        $month = date('m');
        
        // Get the last voucher number for this month
        $lastVoucher = self::where('voucher_number', 'like', "{$prefix}{$year}{$month}%")
            ->orderBy('voucher_number', 'desc')
            ->first();
        
        if ($lastVoucher) {
            $lastNumber = (int) substr($lastVoucher->voucher_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $voucherNumber = $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        
        // Ensure uniqueness by adding microsecond if needed
        $attempts = 0;
        while (self::where('voucher_number', $voucherNumber)->exists() && $attempts < 10) {
            $microsecond = substr(microtime(), 2, 3); // Get microseconds
            $voucherNumber = $prefix . $year . $month . str_pad($newNumber, 3, '0', STR_PAD_LEFT) . $microsecond;
            $attempts++;
        }
        
        return $voucherNumber;
    }

    /**
     * Get anonymized data for public display
     */
    public function getAnonymizedData(): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'contribution_type' => $this->contribution_type,
            'category' => $this->category,
            'description' => $this->description,
            'payment_method' => $this->payment_method,
            'contribution_date' => $this->contribution_date,
            'voucher_number' => $this->voucher_number,
            'location' => $this->location,
            'status' => $this->status,
            // Recipient data is NOT included for privacy
        ];
    }

    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('contribution_date', [$startDate, $endDate]);
    }
}

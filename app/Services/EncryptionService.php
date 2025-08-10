<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class EncryptionService
{
    /**
     * Encrypt sensitive data
     */
    public static function encrypt($data): string
    {
        if (empty($data)) {
            return '';
        }
        
        return Crypt::encryptString($data);
    }
    
    /**
     * Decrypt sensitive data
     */
    public static function decrypt($encryptedData): ?string
    {
        if (empty($encryptedData)) {
            return null;
        }
        
        try {
            return Crypt::decryptString($encryptedData);
        } catch (DecryptException $e) {
            // Log the error for security monitoring
            \Log::error('Decryption failed: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Encrypt multiple fields in an array
     */
    public static function encryptArray(array $data, array $fieldsToEncrypt): array
    {
        foreach ($fieldsToEncrypt as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $data[$field . '_encrypted'] = self::encrypt($data[$field]);
                unset($data[$field]); // Remove plain text
            }
        }
        
        return $data;
    }
    
    /**
     * Decrypt multiple fields in an array
     */
    public static function decryptArray(array $data, array $fieldsToDecrypt): array
    {
        foreach ($fieldsToDecrypt as $field) {
            $encryptedField = $field . '_encrypted';
            if (isset($data[$encryptedField])) {
                $data[$field] = self::decrypt($data[$encryptedField]);
                unset($data[$encryptedField]); // Remove encrypted data
            }
        }
        
        return $data;
    }
    
    /**
     * Generate a secure hash for data integrity
     */
    public static function generateHash($data): string
    {
        return hash('sha256', json_encode($data) . config('app.key'));
    }
    
    /**
     * Verify data integrity
     */
    public static function verifyHash($data, $hash): bool
    {
        return hash_equals(self::generateHash($data), $hash);
    }
}

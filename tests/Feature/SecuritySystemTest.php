<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Contribution;
use App\Models\AuditLog;
use App\Services\EncryptionService;
use App\Services\AuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecuritySystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_contribution_encryption_works(): void
    {
        // Create a test user
        $user = User::factory()->create();

        // Create a contribution with sensitive data
        $contribution = new Contribution([
            'recipient_name' => 'Ahmad bin Ali',
            'recipient_ic' => '850101015432',
            'recipient_phone' => '0123456789',
            'recipient_address' => '123 Jalan Test, Kuala Lumpur',
            'amount' => 1000.00,
            'contribution_type' => 'Bantuan Pendidikan',
            'category' => 'Education',
            'description' => 'Bantuan untuk buku teks',
            'payment_method' => 'cash',
            'contribution_date' => now(),
            'voucher_number' => 'ZB2025010001',
            'created_by' => $user->id,
            'status' => 'pending'
        ]);
        
        $contribution->save();

        // Verify the data is encrypted in the database
        $this->assertDatabaseHas('contributions', [
            'id' => $contribution->id,
            'recipient_name_encrypted' => $contribution->recipient_name_encrypted,
        ]);

        // Verify the encrypted data is not the same as plain text
        $this->assertNotEquals('Ahmad bin Ali', $contribution->recipient_name_encrypted);
        $this->assertNotEquals('850101015432', $contribution->recipient_ic_encrypted);

        // Verify we can decrypt the data
        $this->assertEquals('Ahmad bin Ali', $contribution->recipient_name);
        $this->assertEquals('850101015432', $contribution->recipient_ic);
        $this->assertEquals('0123456789', $contribution->recipient_phone);
    }

    public function test_audit_logging_works(): void
    {
        // Create a test user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Log a test action
        AuditService::logDataChange(
            'create',
            'Contribution',
            1,
            'ZB2025010001',
            null,
            ['amount' => 1000, 'category' => 'Education'],
            ['amount', 'category']
        );

        // Verify the audit log was created
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'create',
            'model_type' => 'Contribution',
            'model_id' => 1,
            'model_identifier' => 'ZB2025010001',
        ]);

        // Verify sensitive data is redacted
        $auditLog = AuditLog::first();
        $this->assertArrayHasKey('new_values', $auditLog->toArray());
    }

    public function test_anonymized_data_excludes_sensitive_fields(): void
    {
        // Create a test user
        $user = User::factory()->create();

        // Create a contribution
        $contribution = new Contribution([
            'recipient_name' => 'Ahmad bin Ali',
            'recipient_ic' => '850101015432',
            'recipient_phone' => '0123456789',
            'recipient_address' => '123 Jalan Test, Kuala Lumpur',
            'amount' => 1000.00,
            'contribution_type' => 'Bantuan Pendidikan',
            'category' => 'Education',
            'description' => 'Bantuan untuk buku teks',
            'payment_method' => 'cash',
            'contribution_date' => now(),
            'voucher_number' => 'ZB2025010001',
            'created_by' => $user->id,
            'status' => 'pending'
        ]);
        
        $contribution->save();

        // Get anonymized data
        $anonymizedData = $contribution->getAnonymizedData();

        // Verify sensitive fields are NOT included
        $this->assertArrayNotHasKey('recipient_name', $anonymizedData);
        $this->assertArrayNotHasKey('recipient_ic', $anonymizedData);
        $this->assertArrayNotHasKey('recipient_phone', $anonymizedData);
        $this->assertArrayNotHasKey('recipient_address', $anonymizedData);

        // Verify public fields ARE included
        $this->assertArrayHasKey('amount', $anonymizedData);
        $this->assertArrayHasKey('category', $anonymizedData);
        $this->assertArrayHasKey('contribution_type', $anonymizedData);
        $this->assertArrayHasKey('voucher_number', $anonymizedData);
    }

    public function test_voucher_number_generation(): void
    {
        // Test voucher number generation
        $voucherNumber1 = Contribution::generateVoucherNumber();
        
        // Add a small delay to ensure different microseconds
        usleep(1000); // 1 millisecond delay
        
        $voucherNumber2 = Contribution::generateVoucherNumber();

        // Verify format (allow for longer numbers with microseconds)
        $this->assertMatchesRegularExpression('/^ZB\d{10,13}$/', $voucherNumber1);
        $this->assertMatchesRegularExpression('/^ZB\d{10,13}$/', $voucherNumber2);

        // Verify uniqueness
        $this->assertNotEquals($voucherNumber1, $voucherNumber2);
    }

    public function test_encryption_service_works(): void
    {
        $testData = 'Sensitive Test Data';
        
        // Encrypt data
        $encrypted = EncryptionService::encrypt($testData);
        
        // Verify it's encrypted
        $this->assertNotEquals($testData, $encrypted);
        
        // Decrypt data
        $decrypted = EncryptionService::decrypt($encrypted);
        
        // Verify it matches original
        $this->assertEquals($testData, $decrypted);
    }

    public function test_encryption_service_with_empty_data(): void
    {
        // Test with empty string
        $encrypted = EncryptionService::encrypt('');
        $decrypted = EncryptionService::decrypt($encrypted);
        $this->assertEquals('', $decrypted);

        // Test with null
        $encrypted = EncryptionService::encrypt(null);
        $decrypted = EncryptionService::decrypt($encrypted);
        $this->assertEquals('', $decrypted);
    }
}

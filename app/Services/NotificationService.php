<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationDelivery;
use App\Models\User;
use App\Models\PublicUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Create a new notification
     */
    public function createNotification(array $data): Notification
    {
        return Notification::create([
            'title' => $data['title'],
            'message' => $data['message'],
            'type' => $data['type'] ?? 'general',
            'priority' => $data['priority'] ?? 'normal',
            'status' => $data['status'] ?? 'pending',
            'scheduled_at' => $data['scheduled_at'] ?? null,
            'user_id' => $data['user_id'],
            'target_audience' => $data['target_audience'] ?? null,
            'delivery_channels' => $data['delivery_channels'] ?? ['email'],
            'template_data' => $data['template_data'] ?? [],
            'metadata' => $data['metadata'] ?? [],
        ]);
    }

    /**
     * Send a notification immediately
     */
    public function sendNotification(Notification $notification): bool
    {
        try {
            $recipients = $this->getRecipients($notification);
            
            foreach ($recipients as $recipient) {
                foreach ($notification->delivery_channels_list as $channel) {
                    $this->createDelivery($notification, $recipient, $channel);
                }
            }

            $notification->markAsSent();
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            $notification->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Send scheduled notifications
     */
    public function sendScheduledNotifications(): int
    {
        $notifications = Notification::scheduled()->get();
        $sentCount = 0;

        foreach ($notifications as $notification) {
            if ($this->sendNotification($notification)) {
                $sentCount++;
            }
        }

        return $sentCount;
    }

    /**
     * Create a delivery record
     */
    public function createDelivery(Notification $notification, $recipient, string $channel): NotificationDelivery
    {
        $delivery = NotificationDelivery::create([
            'notification_id' => $notification->id,
            'recipient_type' => get_class($recipient),
            'recipient_id' => $recipient->id,
            'channel' => $channel,
            'status' => 'pending',
        ]);

        // Send via the appropriate channel
        $this->sendViaChannel($delivery, $recipient, $channel);

        return $delivery;
    }

    /**
     * Send notification via specific channel
     */
    protected function sendViaChannel(NotificationDelivery $delivery, $recipient, string $channel): void
    {
        try {
            switch ($channel) {
                case 'email':
                    $this->sendEmail($delivery, $recipient);
                    break;
                case 'sms':
                    $this->sendSMS($delivery, $recipient);
                    break;
                case 'push':
                    $this->sendPushNotification($delivery, $recipient);
                    break;
                case 'in_app':
                    $this->sendInAppNotification($delivery, $recipient);
                    break;
                default:
                    throw new \Exception("Unsupported channel: {$channel}");
            }

            $delivery->markAsSent();
        } catch (\Exception $e) {
            Log::error("Failed to send notification via {$channel}: " . $e->getMessage());
            $delivery->markAsFailed($e->getMessage());
        }
    }

    /**
     * Send email notification
     */
    protected function sendEmail(NotificationDelivery $delivery, $recipient): void
    {
        $notification = $delivery->notification;
        
        // Get recipient email
        $email = $recipient->email ?? $recipient->contact_email ?? null;
        
        if (!$email) {
            throw new \Exception("No email address found for recipient");
        }

        // Send email using Laravel's mail system
        Mail::send('emails.notification', [
            'notification' => $notification,
            'recipient' => $recipient,
            'delivery' => $delivery,
        ], function ($message) use ($email, $notification) {
            $message->to($email)
                   ->subject($notification->title);
        });

        $delivery->markAsDelivered();
    }

    /**
     * Send SMS notification
     */
    protected function sendSMS(NotificationDelivery $delivery, $recipient): void
    {
        $notification = $delivery->notification;
        
        // Get recipient phone number
        $phone = $recipient->phone ?? $recipient->contact_phone ?? null;
        
        if (!$phone) {
            throw new \Exception("No phone number found for recipient");
        }

        // Here you would integrate with an SMS service like Twilio, Nexmo, etc.
        // For now, we'll just log the SMS
        Log::info("SMS would be sent to {$phone}: {$notification->message}");

        $delivery->markAsDelivered();
    }

    /**
     * Send push notification
     */
    protected function sendPushNotification(NotificationDelivery $delivery, $recipient): void
    {
        $notification = $delivery->notification;
        
        // Here you would integrate with a push notification service
        // For now, we'll just log the push notification
        Log::info("Push notification would be sent: {$notification->title}");

        $delivery->markAsDelivered();
    }

    /**
     * Send in-app notification
     */
    protected function sendInAppNotification(NotificationDelivery $delivery, $recipient): void
    {
        $notification = $delivery->notification;
        
        // For in-app notifications, we just mark as delivered
        // The frontend will fetch and display these
        $delivery->markAsDelivered();
    }

    /**
     * Get recipients based on target audience
     */
    protected function getRecipients(Notification $notification): array
    {
        $targetAudience = $notification->target_audience ?? [];
        $recipients = [];

        if (empty($targetAudience) || in_array('all', $targetAudience)) {
            // Send to all users
            $recipients = array_merge(
                User::all()->toArray(),
                PublicUser::all()->toArray()
            );
        } else {
            foreach ($targetAudience as $target) {
                switch ($target) {
                    case 'admin_users':
                        $recipients = array_merge($recipients, User::all()->toArray());
                        break;
                    case 'public_users':
                        $recipients = array_merge($recipients, PublicUser::all()->toArray());
                        break;
                    case 'initiative_applicants':
                        // Get users who have applied to initiatives
                        $applicants = PublicUser::whereHas('initiativeApplications')->get();
                        $recipients = array_merge($recipients, $applicants->toArray());
                        break;
                    default:
                        // Handle custom audience types
                        break;
                }
            }
        }

        return $recipients;
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(NotificationDelivery $delivery): void
    {
        $delivery->markAsRead();
    }

    /**
     * Get unread notifications for a user
     */
    public function getUnreadNotifications($user): \Illuminate\Database\Eloquent\Collection
    {
        return NotificationDelivery::where('recipient_type', get_class($user))
            ->where('recipient_id', $user->id)
            ->whereNull('read_at')
            ->with('notification')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get notification statistics
     */
    public function getNotificationStats(): array
    {
        $totalNotifications = Notification::count();
        $sentNotifications = Notification::where('status', 'sent')->count();
        $pendingNotifications = Notification::where('status', 'pending')->count();
        $failedNotifications = Notification::where('status', 'failed')->count();

        $totalDeliveries = NotificationDelivery::count();
        $sentDeliveries = NotificationDelivery::where('status', 'sent')->count();
        $deliveredDeliveries = NotificationDelivery::where('status', 'delivered')->count();
        $failedDeliveries = NotificationDelivery::where('status', 'failed')->count();

        return [
            'notifications' => [
                'total' => $totalNotifications,
                'sent' => $sentNotifications,
                'pending' => $pendingNotifications,
                'failed' => $failedNotifications,
            ],
            'deliveries' => [
                'total' => $totalDeliveries,
                'sent' => $sentDeliveries,
                'delivered' => $deliveredDeliveries,
                'failed' => $failedDeliveries,
                'delivery_rate' => $totalDeliveries > 0 ? round(($deliveredDeliveries / $totalDeliveries) * 100, 2) : 0,
            ],
        ];
    }

    /**
     * Retry failed deliveries
     */
    public function retryFailedDeliveries(): int
    {
        $failedDeliveries = NotificationDelivery::where('status', 'failed')->get();
        $retryCount = 0;

        foreach ($failedDeliveries as $delivery) {
            try {
                $recipient = $delivery->recipient;
                $this->sendViaChannel($delivery, $recipient, $delivery->channel);
                $retryCount++;
            } catch (\Exception $e) {
                Log::error("Failed to retry delivery {$delivery->id}: " . $e->getMessage());
            }
        }

        return $retryCount;
    }

    /**
     * Clean up old notifications
     */
    public function cleanupOldNotifications(int $days = 90): int
    {
        $cutoffDate = Carbon::now()->subDays($days);
        
        $deletedCount = Notification::where('created_at', '<', $cutoffDate)
            ->where('status', 'sent')
            ->delete();

        return $deletedCount;
    }
}

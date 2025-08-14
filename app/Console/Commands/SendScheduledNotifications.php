<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class SendScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:send-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send scheduled notifications that are due';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService)
    {
        $this->info('Starting scheduled notification delivery...');

        try {
            $sentCount = $notificationService->sendScheduledNotifications();

            if ($sentCount > 0) {
                $this->info("Successfully sent {$sentCount} scheduled notifications.");
            } else {
                $this->info('No scheduled notifications were due for delivery.');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to send scheduled notifications: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

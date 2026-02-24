<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $notificationData
    ) {
        $this->onQueue('notifications');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Push to BullMQ via Redis
        $redis = Redis::connection();
        
        $jobData = [
            'data' => $this->notificationData,
            'opts' => [
                'attempts' => 3,
                'backoff' => 3000,
                'removeOnComplete' => true,
            ],
        ];

        $redis->lpush('bull:notifications:wait', json_encode($jobData));
        
        \Log::info('Notification dispatched to BullMQ', [
            'userId' => $this->notificationData['userId'] ?? 'unknown',
            'type' => $this->notificationData['type'] ?? 'unknown',
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error('Notification job failed', [
            'error' => $exception->getMessage(),
            'data' => $this->notificationData,
        ]);
    }
}

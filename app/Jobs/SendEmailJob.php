<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $emailData
    ) {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Push to BullMQ via Redis
        $redis = Redis::connection();
        
        $jobData = [
            'data' => $this->emailData,
            'opts' => [
                'attempts' => 3,
                'backoff' => 5000,
                'removeOnComplete' => true,
            ],
        ];

        $redis->lpush('bull:emails:wait', json_encode($jobData));
        
        \Log::info('Email job dispatched to BullMQ', [
            'to' => $this->emailData['to'] ?? 'unknown',
            'subject' => $this->emailData['subject'] ?? 'unknown',
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error('Email job failed', [
            'error' => $exception->getMessage(),
            'data' => $this->emailData,
        ]);
    }
}

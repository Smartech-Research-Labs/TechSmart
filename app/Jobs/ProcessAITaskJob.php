<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ProcessAITaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 180;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $taskData
    ) {
        $this->onQueue('ai-tasks');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Push to BullMQ via Redis
        $redis = Redis::connection();
        
        $jobData = [
            'data' => $this->taskData,
            'opts' => [
                'attempts' => 2,
                'backoff' => 10000,
                'removeOnComplete' => false,
                'removeOnFail' => false,
            ],
        ];

        $redis->lpush('bull:ai-tasks:wait', json_encode($jobData));
        
        \Log::info('AI task dispatched to BullMQ', [
            'task' => $this->taskData['task'] ?? 'unknown',
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error('AI task failed', [
            'error' => $exception->getMessage(),
            'task' => $this->taskData,
        ]);
    }
}

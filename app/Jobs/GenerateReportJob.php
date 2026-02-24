<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    public $timeout = 300;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $reportData
    ) {
        $this->onQueue('reports');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Push to BullMQ via Redis
        $redis = Redis::connection();
        
        $jobData = [
            'data' => $this->reportData,
            'opts' => [
                'attempts' => 2,
                'backoff' => 30000,
                'removeOnComplete' => false,
                'timeout' => 300000, // 5 minutes
            ],
        ];

        $redis->lpush('bull:reports:wait', json_encode($jobData));
        
        \Log::info('Report generation dispatched to BullMQ', [
            'reportType' => $this->reportData['reportType'] ?? 'unknown',
            'userId' => $this->reportData['userId'] ?? 'unknown',
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Log::error('Report generation failed', [
            'error' => $exception->getMessage(),
            'data' => $this->reportData,
        ]);
    }
}

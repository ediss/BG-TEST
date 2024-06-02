<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FetchFilesData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cacheKey = 'files_urls';

        try {
            $response = Http::get('https://rest-test-eight.vercel.app/api/test');
            $filesUrls = $response->json();

            $data = $filesUrls['items'];
            Cache::put($cacheKey, $data);
        } catch (\Exception $e) {
            Log::error('Exception occurred while fetching files URLs', ['exception' => $e]);
        }
    }
}

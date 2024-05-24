<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FileController extends Controller
{
    public function index(): array {

        $cacheKey = 'files_urls';

        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);
        } else {

            try {
                $response = Http::get('https://rest-test-eight.vercel.app/api/test');
                $filesUrls = $response->json();

                $data = $filesUrls['items'];
                Cache::put($cacheKey, $data);
            } catch (\Exception $e) {
                Log::error('Exception occurred while fetching files URLs', ['exception' => $e]);
                throw new Exception('Exception occurred while fetching files URLs', 0, $e);
            }

        }

        
        return $this->transformData($data);
    }


    //could be in some service 
    public function transformData(array $data): array {

        $transformedData = [];

        foreach ($data as $url) {
            
            $urlParts = explode('/', $url['fileUrl']);
            $ipAddress = $this->extractIpAddress($urlParts[2]);


            $directory = $urlParts[3];
            $subDirectory = $urlParts[4] ?? null;
            $fileName = end($urlParts);

            if ($subDirectory  && $subDirectory !== $fileName) {
                $transformedData[$ipAddress][$directory][$subDirectory][] = $fileName;
                
            } else {
                $transformedData[$ipAddress][$directory][] = $fileName;
            }
        }

        return $transformedData;

    }

    private function extractIpAddress(string $host): string
    {
        return explode(':', $host)[0];
    }
}

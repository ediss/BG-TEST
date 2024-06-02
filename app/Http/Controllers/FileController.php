<?php

namespace App\Http\Controllers;
use App\Jobs\FetchFilesData;
use Illuminate\Support\Facades\Cache;

class FileController extends Controller
{
    public function index(): array
    {
        $cacheKey = 'files_urls';

        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);
        } else {
            FetchFilesData::dispatch();

            $data = [];
        }

        return $this->setFileDataStructure($data);
    }


    //could be in some service 
    public function setFileDataStructure(array $data): array {

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

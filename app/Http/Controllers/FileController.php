<?php

namespace App\Http\Controllers;
use App\Jobs\FetchFilesData;
use Illuminate\Support\Facades\Cache;
use App\Services\FileStructureService;

class FileController extends Controller
{

    protected $fileStructureService;

    public function __construct(FileStructureService $fileStructureService)
    {
        $this->fileStructureService = $fileStructureService;
    }

    public function index(): array
    {
        $cacheKey = 'files_urls';

        if (Cache::has($cacheKey)) {
            $data = Cache::get($cacheKey);
        } else {
            FetchFilesData::dispatch();

            $data = [];
        }

        return $this->fileStructureService->setFileStructureFromUrls($data);

    }
}

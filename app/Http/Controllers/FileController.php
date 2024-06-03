<?php

namespace App\Http\Controllers;
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
        $data = $this->fileStructureService->getCachedFilesOrDispatchJob();

        return $this->fileStructureService->setFileStructureFromUrls($data);

    }
}

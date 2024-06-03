<?php

namespace App\Http\Controllers;
use App\Http\Resources\FileCollection;
use App\Services\FileStructureService;

class FileController extends Controller
{

    protected $fileStructureService;

    public function __construct(FileStructureService $fileStructureService)
    {
        $this->fileStructureService = $fileStructureService;
    }
    
    public function index(): FileCollection
    {
        
        $data = $this->fileStructureService->getCachedFilesOrDispatchJob();

        $filesStructure = $this->fileStructureService->setFileStructureFromUrls($data);

        return new FileCollection(collect($filesStructure));

    }

}

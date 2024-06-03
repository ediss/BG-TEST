<?php

namespace App\Services;

class FileStructureService
{
    public function setFileStructureFromUrls(array $data): array
    {
        $fileStructure = [];

        foreach ($data as $url) {
            $urlParts = explode('/', $url['fileUrl']);
            $ipAddress = $this->extractIpAddress($urlParts[2]);

            $directory = $urlParts[3];
            $subDirectory = $urlParts[4] ?? null;
            $fileName = end($urlParts);

            if ($subDirectory && $subDirectory !== $fileName) {
                $fileStructure[$ipAddress][$directory][$subDirectory][] = $fileName;
            } else {
                $fileStructure[$ipAddress][$directory][] = $fileName;
            }
        }

        return $fileStructure;
    }

    private function extractIpAddress(string $host): string
    {
        return explode(':', $host)[0];
    }
}

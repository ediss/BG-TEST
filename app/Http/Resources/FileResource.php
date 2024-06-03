<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ip_address' => $this->ip_address,
            'directory' => $this->directory,
            'sub_directory' => $this->sub_directory,
            'files' => $this->files,
        ];
    }
}

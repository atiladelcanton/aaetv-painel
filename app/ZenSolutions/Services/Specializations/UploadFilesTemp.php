<?php


namespace App\ZenSolutions\Services\Specializations;

use App\ZenSolutions\Helpers\LogError;
use App\ZenSolutions\Helpers\Upload;
use Exception;
use Illuminate\Support\Facades\Storage;

class UploadFilesTemp
{
    private $path;

    private $file;

    public function __construct(string $path,  $file)
    {
        $this->path = $path;
        $this->file = $file;
    }

    public function execute()
    {
        try {
            if (!Storage::exists($this->path)) {
                Storage::makeDirectory($this->path);
            }

            return Upload::uploadFile('document', $this->path, $this->file);
        } catch (Exception $exception) {
            LogError::log($exception);
        }
    }
}

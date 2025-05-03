<?php

trait HandleFileTrait
{
    /*
    |--------------------------------------------------------------------------
    | Upload Files Function
    |--------------------------------------------------------------------------
    */

    public function UploadFiles($file, $name = null, $fileType)
    {
        $folder = $this->getFolderByFileType($fileType);
        return $this->uploadFile($file, $name, $folder);
    }

    private function getFolderByFileType($fileType)
    {
        switch ($fileType) {
            case 'image':
                return 'img';
            case 'video':
                return 'videos';
            default:
                return 'cv';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Upload File Function
    |--------------------------------------------------------------------------
    */

    private function uploadFile($fileTmp, $file, $folder)
    {
        $randomName = uniqid();
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $fileFullName = $randomName . '_' .  $fileName;
        $path = $folder . '/' . $fileFullName . '.' . $extension;
        // $fullPath = 'assets/' . $path;
        move_uploaded_file($fileTmp,$path);

        return $path;
    }

    /*
    |--------------------------------------------------------------------------
    | Delete File Function
    |--------------------------------------------------------------------------
    */

    public function deleteFile($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
            return true;
        } else {
            return false;
        }
    }
}
?>

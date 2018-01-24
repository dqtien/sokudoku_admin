<?php
namespace App\Traits;

trait UploadFileHelper
{

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function makeFileName()
    {
        $random_string = $this->generateRandomString();

        $fileName = null;

        $fileName = $random_string . '_' . time() . '.jpeg';

        return $fileName;
    }

    public function moveFile($fileUpload)
    {
        try {
            $fileName = $this->makeFileName();
            $url = null;

            move_uploaded_file($fileUpload->path(), public_path('avatar') . '/' . $fileName);
            return asset('/avatar/' . $fileName);
        } catch (\Exception $e) {
            return false;
        }
    }
}
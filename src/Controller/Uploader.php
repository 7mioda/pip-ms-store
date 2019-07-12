<?php
namespace App\Controller;

use Cloudinary;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    public function uploadImage(UploadedFile $file, ?Array $options)
    {
        $fileName = $file->getRealPath();

        Cloudinary::config([
            "cloud_name" => getenv('CLOUD_NAME'),
            'api_key' => getenv('API_KEY'),
            "api_secret" => getenv('API_SECRET')
        ]);

        if(!$options){
            $options = [
                'folder' => 'symfony-listing',
                'width' => 200,
                'height' => 200
            ];
        }

        $imageUploaded = Cloudinary\Uploader::upload($fileName, $options);

        return $imageUploaded['secure_url'];
    }
}

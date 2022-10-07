<?php

namespace Tool;

class ImageUploader
{
    public string $name;
    public string $basePath;
    public bool $success;

    private SourceImage $image;

    public ResizeImage $resizer;

    public $saveImage;

    public function __construct(array $data, string $base)
    {

        $this->basePath = $base;
        if (isset($data['image'])) {
            if ($data['image']['error'] == 0) {
                $image = $data['image'];
                $this->image = new SourceImage($image);
                $this->resizer = new ResizeImage($this->image);
                if ($this->getFunction()) {
                    $this->success = true;
                }
            } else {
                $this->success = false;
            }
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    private function getFunction()
    {
        switch ($this->image->type) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                break;
            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                break;
            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                break;
            default:
                return false;
        }

        list($type, $format) = explode('/', $this->image->type);

        $this->name = ''.time().'.'.$format;

        $this->saveImage = $image_create_func($this->image->sourcePath);
        $tn = imagecreatetruecolor($this->resizer->width, $this->resizer->height) ;
        imagecopyresampled($tn, $this->saveImage, 0, 0, 0, 0, $this->resizer->width, $this->resizer->height, $this->image->width, $this->image->height) ;

        $image_save_func($tn, $this->basePath.$this->name);
        return true;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}

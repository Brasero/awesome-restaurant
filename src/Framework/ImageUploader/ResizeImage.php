<?php

namespace App\Framework\ImageUploader;

class ResizeImage
{


    private SourceImage $image;
    private float $ratio;
    public int $width;
    public int $height;


    public function __construct(SourceImage $image)
    {
        $this->image = $image;
        $this->calcRatio();
        $this->calcSize();
    }


    private function calcRatio(): void
    {
        $ratio = intval($this->image->width) / intval($this->image->height);
        $this->ratio = $ratio;
    }

    private function calcSize(): void
    {
        $newHeight = 450;
        $newWidth = $newHeight * $this->ratio;
        $this->width = $newWidth;
        $this->height = $newHeight;
    }
}

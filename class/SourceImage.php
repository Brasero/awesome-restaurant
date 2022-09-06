<?php

namespace Tool;

class SourceImage {
    public string $name;
    public string $type;
    public string $sourcePath;
    public string $size;
    public string $error;
    public string $width;
    public string $height;

    public function __construct(array $data){
        $this->name = $data['name'];
        $this->type = $data['type'];
        $this->sourcePath = $data['tmp_name'];
        $this->error = $data['error'];
        $this->size = $data['size'];
        $this->completeObject();
    }

    private function completeObject(): void 
    {
        if($this->error == 0){
            $this->setFormat();
        }
        else {
            var_dump($_FILES);
            throw new \Exception("Erreur de chargement");
        }
    }

    /**
     * Definie quel sont les mesures de la photo
     *
     * @return void
     */
    public function setFormat(): void 
    {
        list($width, $height) = getimagesize($this->sourcePath);
        $this->width = $width;
        $this->height = $height;
    }
}
<?php

namespace App\Services;

class FileLogoCreate
{

    private $path;
    private $image_parts;
    private $image_type_aux;
    private $image_type;
    private $image_en_base64;
    private $file;
    private $extensions = ['png', 'jpg', 'jpeg'];

    public function __construct($path = '', $image_parts = '', $image_type_aux = '', $image_type = '', $image_en_base64 = '', $file = '')
    {
        $this->path = $path;
        $this->image_parts = $image_parts;
        $this->image_type_aux = $image_type_aux;
        $this->image_type = $image_type;
        $this->image_en_base64 = $image_en_base64;
        $this->file = $file;
    }

    /**
     * @param string $picture64, $userEmail
     * @return string $file
     */
    public function createPicture(string $picture64, string $userEmail): string
    {

        $this->path = "assets/images/" . $userEmail . '/logo/';               // definit chemin du dossier
        array_map('unlink', glob($this->path . "/*.*"));                       // supprime fichiers dans le dossier  
        $this->image_parts = explode(";base64,", $picture64);                 // scinde le fichier 0 => "data:image/png", 1 => "imagebase64"
        $this->image_type_aux = explode("image/", $this->image_parts[0]);     // correspopnd 0 => 'data, 1 => 'png'

        $image_type = $this->image_type_aux[1];                               // renvoie extension 'png'
        if (!in_array($image_type, $this->extensions))                         // Si l'extension n'est pas dans le tableau
        {
            return '409';
        }

        $this->image_en_base64 = base64_decode($this->image_parts[1]);        // correspond au code image decodée de base64
        $this->file = $this->path . uniqid() . '.' . $image_type;             // création numéro image unique
        file_put_contents($this->file, $this->image_en_base64);               // ecrit dans le fichier 
        return $this->file;
    }
}

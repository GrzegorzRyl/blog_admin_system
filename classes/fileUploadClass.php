<?php

Class FileUpload
{
    public $info_upload;
    protected $image_type;
    protected $image_size;
    protected $image_temp;
    protected $image_max_size = 9*1024*1024;
    protected $file_folder = "img/";
    protected $allowed_image_types = ["image/jpeg", "image/jpg", "image/png"];


    public function __construct($image)
    {
        $this ->image_name = $image['image']['name'];
        $this ->image_size = $image['image']['size'];
        $this ->image_temp = $image['image']['tmp_name'];
        $this ->image_type = $image['image']['type'];

        $this->isImage();
        if($this -> info_upload == null){
            $this->nameValidation();    
        }
        if($this -> info_upload == null){
            $this->sizeValidation();
        }
        if($this -> info_upload == null){
            $this->checkFile();
        }
        
        if($this -> info_upload == null){
            $this->moveFile(); 
        } 
        
        

    }

    private function isImage()
    {
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $this->image_temp);
        finfo_close($file_info);
        
        if(!in_array($mime_type, $this->allowed_image_types)){
            return $this->info_upload = "zły format pliku!";
        }
    }

    public function nameValidation()
    {
         return $this->image_name = filter_var($this->image_name, FILTER_SANITIZE_STRING); //to tylko zmienia nazwe na właściwą(nie sprawdza czy już jest poprawna)
    }

    public function sizeValidation()
    {   
        if($this->image_size > $this->image_max_size){
            return $this->info_upload = "plik musi być mniejszy niż 9MB";;
        }
    }

    public function checkFile()
    {   
        if(file_exists($this->file_folder . $this->image_name)){
            return $this->info_upload = "zdjęcie już istnieje";
        }   
    }

    public function moveFile()
    {
        if(!move_uploaded_file($this->image_temp, $this->file_folder . $this->image_name)){
            return $this->info_upload = "błąd podczas zapisu zdjęcia";
        }
    }

}
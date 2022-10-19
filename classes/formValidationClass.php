<?php

Class FormValidation
{
    public $info_form;
    private $article_title;
    private $article_content;
    private $image_name;
    private $page_title;
    private $meta_desription;
    private $page_title_max_lenght = 60;
    private $meta_description_max_lenght = 140;


    public function __construct(string $article_title, string $article_content, string $image_name, string $page_title, string $meta_description, bool $is_edit)
    {
        $this -> article_title = $article_title;
        $this -> article_content = $article_content;
        $this -> image_name = $image_name;
        $this -> page_title = $page_title;
        $this -> meta_description = $meta_description;

        if($is_edit == true and $image_name == ''){
            return $this-> info_form = null;
        } else {
            $this->titleValidation();
            if($this -> info_form == null){
                $this->contentValidation();
            } 
            if($this -> info_form == null){
                $this->imageNameValidation();
            }
            if($this -> info_form == null){
                $this->pageTitleValidation();
            }
            if($this -> info_form == null){
                $this->metaDescriptionValidation();
            }

        }


        
        
        
        
    }


    
    private function titleValidation(){
        if($this -> article_title == null){
            return $this -> info_form = "Wpisz tytuł artykułu";
            
        }
    }

    private function contentValidation(){
        if($this -> article_content == null){
            return $this -> info_form = "Wpisz treść artykułu";
        }
    }

    private function imageNameValidation(){
        if($this -> image_name == null){
            return $this -> info_form = "Wybierz zdjęcie";
        }
        
    }

    private function pageTitleValidation()
    {
        if($this -> page_title == ""){
            $this -> info_form = "Wpisz tytuł strony";
        }
        if(strlen($this -> page_title) > $this -> page_title_max_lenght){
            $this -> info_form = "Zbyt długi tytuł strony - max 60 znaków";
        }
        return $this -> info_form;
    }

    private function metaDescriptionValidation()
    {
        if($this -> meta_description == ""){
            $this -> info_form = "Wpisz meta description";
        }
        if(strlen($this -> meta_description) > $this -> meta_description_max_lenght){
            $this -> info_form = "Zbyt długi meta description - max 140 znaków";
        }
        return $this -> info_form;
    }



}
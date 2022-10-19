<?php

Class DeleteArticle
{
public $info_delete;
private $article_id;
private $file_content;
private $articles_index;

    public function __construct($article_id, $file_content, $articles_index)
    {
        $this -> article_id = $article_id;
        $this -> file_content = $file_content;
        $this -> articles_index = $articles_index;

        $this -> deleteImage();

        if($this -> info_delete == null){
            $this -> deleteLongArticle();
        }
        
        if($this -> info_delete == null){
            $this -> deleteShortArticle();
        }

        if($this -> info_delete == null){
            $this -> info_delete = "delete_ok";
        }
    }

    private function deleteLongArticle()
    {
        if(!unlink("articles/" . $this -> article_id . ".json")){
            $this -> info_delete = "Błąd usuwania pliku artykułu";
        }

    }

    private function deleteShortArticle()
    {  
        $old_content = $this -> file_content;
        $id = $this-> article_id;
        unset($old_content[$id]);
        $new_content_JSON = json_encode($old_content, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
        if(!file_put_contents("articles/" . $this -> articles_index, $new_content_JSON)){
            return $this->info_delete = "Błąd podczas ponownego zapisu";      
        }
    }

    private function deleteImage()
    {
        $file_content = $this -> file_content;
        $img_name = $file_content[$this -> article_id]['img_source'];
        if(!unlink("img/" . "$img_name")){
            $this -> info_delete = "Błąd usuwania zdjęcia";
        }
    }

        
}






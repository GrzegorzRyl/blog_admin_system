<?php

class FileHandling
{
 
    public $info_handling;
    public $image_name;
    public $article_title;
    public $article_content;
    public $article_id;
    public $page_title;
    public $meta_description;
    private $file_folder = "img/";
    private $short_file_name = "articles_index.json";


    // =================Constructor =======================
    public function __construct(string $article_title, string $article_content, string $image_name, $article_id,
                                string $page_title, string $meta_description, bool $is_edit)
    {
        $this -> article_title = $article_title;
        $this -> article_content = $article_content;
        $this -> image_name = $image_name;
        $this -> article_id = $article_id;
        $this -> page_title = $page_title;
        $this -> meta_description = $meta_description;
        $this -> is_edit = $is_edit;

        if($is_edit == false) {
            $this-> createArticle($this -> article_title, $this -> article_content, $this -> image_name, $this -> page_title, $this -> meta_description);
        }
        if($is_edit == true) {
            $this-> updateArticle($this -> article_title, $this -> article_content, $this ->article_id, $this -> image_name, $this -> page_title, $this -> meta_description);
        }
                
        if($this -> info_handling != null) {
            if(file_exists($this -> file_folder . $this -> image_name)){
                unlink($this -> file_folder . $this -> image_name);
            }
        }
        
    }



    //=================metody===================================
    private function getTime()
    {
        $actual_date = date("d.m.Y");
        return $actual_date;
    }

    private function encodeDataToJSON($data)
    {
        $data_encoded = json_encode($data, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
        return $data_encoded;
    }

    private function writeLongData($long_data_to_write,$file_name)
    {
        $content_JSON = $this->encodeDataToJSON($long_data_to_write);
        if(!file_put_contents("articles/$file_name.json", $content_JSON)){
            return $this->info_handling = "Błąd podczas zapisu";
        }
    }

    public function writeShortData($short_data_to_write, $file_name)
    {
        if(!file_put_contents("articles/$file_name", $short_data_to_write)){
            return $this->info_handling = "Błąd podczas zapisu";
        }
        
    }

    public function readData($file_name)
    {
        $file_data = file_get_contents("articles/$file_name");
        $decoded_data = json_decode($file_data,true);
        return $decoded_data;
    }

    private function deleteImage($img_name)
    {
        if(!unlink("img/" . "$img_name")){
            $this -> info_delete = "Błąd usuwania starego zdjęcia podczas edycji";
        }
    }

    public function createArticle(string $article_title, string $article_content, string $img_name, string $page_title, string $meta_description)
    {   
        $created = $this-> getTime();
        $id = uniqid().''.uniqid();
        $last_edit = '';
        $long_data = array("$id"=> array("title" => "$article_title", "content" => "$article_content",
                                         "created" => "$created", "last_edit" => $last_edit,
                                         "img_source" => $img_name, "page_title" => $page_title, "meta_description" => $meta_description));
        $short_data = array("$id"=> array("title" => "$article_title", "created" => "$created",
                                          "img_source" => $img_name, "last_edit" => $last_edit));                                    
        
        $result_data = $this->writeLongData($long_data, $id);

        $file_name = $this->short_file_name;
        $old_content = $this->readData($file_name);
        if('' == $old_content){
            $new_content_JSON = $this -> encodeDataToJSON($short_data);
            $result_data = $this->writeShortData($new_content_JSON);
        } else {
            $new_content = array_merge($old_content, $short_data);
            $new_content_JSON = $this->encodeDataToJSON($new_content);
            $result_data = $this->writeShortData($new_content_JSON, $file_name);
        }
        return $result_data;
    }

    public function updateArticle(string $article_title, string $article_content, string $id, string $img_name, string $page_title, string $meta_description) //to trzeba rozpracować jeszcze raz ze zdjęciem
    {
        $last_edit = $this -> getTime();
        $new_title = $article_title;
        $new_content = $article_content;
        $new_img_name = $img_name;
        $new_page_title = $page_title;
        $new_meta_description = $meta_description;
        $long_file_name = "$id.json";
        $short_file_name = $this-> short_file_name;
        $file_content = $this->readData($long_file_name);
        foreach($file_content as $article => $article_value) {
            if($article == $id){
                if($new_img_name != $article_value["img_source"] and $new_img_name != ''){
                    $this -> deleteImage($article_value["img_source"]);
                }
                if ($new_img_name == ''){
                    $new_img_name = $article_value["img_source"];
                }
                $long_data = array("$id"=> array("title" => "$new_title", "content" => "$new_content",
                                         "created" => $article_value["created"], "last_edit" => $last_edit,
                                         "img_source" => $new_img_name, "page_title" => $new_page_title, "meta_description" => $new_meta_description));

            }
            $result_data = $this->writeLongData($long_data, $id);
            
        }    
        
        $file_content = $this->readData($short_file_name);
        foreach($file_content as $article => $article_value){
            if($article == $id){
                
                $short_data = array("$id"=> array("title" => "$new_title", "created" => $article_value["created"],
                                          "img_source" => $new_img_name, "last_edit" => $last_edit));
                $new_array = array_replace($file_content, $short_data);
                $new_content_JSON = $this->encodeDataToJSON($new_array);
                $result_data = $this -> writeShortData($new_content_JSON, $short_file_name);
                return $result_data;
            }
        }                       
    }


}



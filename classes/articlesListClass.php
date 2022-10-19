<?php

Class ArticlesList
{   
    public function getData($file_name){
        $file_data = file_get_contents("articles/" . "$file_name");
        $decoded_data = json_decode($file_data,true);
        return $decoded_data;
    }
    
}
?>
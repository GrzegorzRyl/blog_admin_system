<?php session_start(); ?>
<?php
include 'classes/articlesListClass.php';

if(isset($_SESSION['user'])){
    $article_list= new ArticlesList();
    if(isset($_GET)){
        if(isset($_GET["article_id"])){
            $article_id = $_GET["article_id"];
            $file_name = "$article_id.json";
            $file_content = $article_list->getData($file_name);
            foreach($file_content as $article => $article_value){
                if($article_id == $article){
                    $title_to_show = $article_value["title"];
                    $content_to_show = $article_value["content"];
                    $img_to_show = $article_value["img_source"];
                }
                echo "<img src='img/$img_to_show' onclick='triggerClick()'' id='image_display' width='400' height='300'>";
                echo "<h2> $title_to_show</h2>";
                echo "<a> $content_to_show</a></br>";
                echo "<a href='articleslist'><button>Powrót</button></a>";
    
    
            }
        }
    }

}else{
    ?>
    <button><a href = '../login/loginform'>Zaloguj się</a></button>
<?php 
    echo "Musisz się zalogować";
}
?> 


    


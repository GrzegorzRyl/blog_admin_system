<?php session_start(); ?>
<?php

include 'classes/fileHandlingClass.php';
include 'classes/fileUploadClass.php';
include 'classes/articlesListClass.php';
include 'classes/formValidationClass.php';

$info_upload = null;
$info_handling = null;
$info_form = null;
$article_title = null;
$article_content = null;
$article_id = '';
$page_title = null;
$meta_description = null;
$is_edit = false;
$image_name = '';
$button_name = 'create';
$img_source = "placeholder.png";

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
}

if(isset($_GET)){
    $article_list = new ArticlesList();
    
    if(isset($_GET["article_id"])){
        $button_name = 'edit';
        $article_id = $_GET["article_id"];
        $file_name = "$article_id.json";
        $article = $article_list->getData($file_name);
        foreach ($article as $article => $article_value){
            if($article_id == $article){
                $article_title = $article_value["title"];
                $article_content = $article_value["content"];
                $page_title = $article_value["page_title"];
                $meta_description = $article_value["meta_description"];
                $img_source = $article_value["img_source"];
            }
        }
    }
}


//jak ogarnać polskie znaki??
if(isset($_POST["create"]) || isset($_POST["edit"]) ){
    
    $article_title = $_POST["title"];
    $article_content = $_POST["content"];
    $page_title = $_POST["page_title"];
    $meta_description = $_POST["meta_description"];

    if(isset( $_GET['article_id'])){
        $article_id = $_GET['article_id'];
    }
        
    if(isset($_POST["edit"])){
        $is_edit = true;
    }

    if(isset($_FILES['image']['name'])){
        $image_name = $_FILES['image']['name'];
    }
    
//=========================================================================

    $formValidation = new FormValidation($article_title, $article_content, $image_name, $page_title, $meta_description, $is_edit);
    $info_form = $formValidation -> info_form;
    
        if($info_form == null){
            
                if($_FILES['image']['error'] == 0){
                    $fileUpload = new FileUpload($_FILES);
                    $image_name = $fileUpload -> image_name;
                    $info_upload = $fileUpload -> info_upload; 
                } else {
                    if($is_edit == false){
                        $info_form = "błąd podczas ładowania zdjęcia";
                    }
                    
                }
            }
        
    


    if($info_form == null and $info_upload == null){
        $fileHandling = new FileHandling($article_title, $article_content, $image_name, $article_id,
        $page_title, $meta_description, $is_edit);
        $info_handling = $fileHandling -> info_handling;
    }

    if($info_handling == null and $info_upload == null and $info_form == null){
        header("Location: result");
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Formularz</title>
    </head>
<body>

<?php    
    if(isset($_SESSION['user'])){
        echo "Witaj: " . $_SESSION['user'];
        $is_logged = true;
    ?>
        <form method="post">
        <button type="submit" name="logout">Wyloguj</button>
        </form>




<form method= "post" enctype="multipart/form-data">


    <h4>Tytuł artykułu:</h4> 
    <textarea type="text" name="title" rows="1"><?php echo $article_title;?></textarea></br></br>
    <h4> treśc artykułu: </h4>
    <textarea name="content" id="content" rows="10"><?php echo $article_content;?></textarea></br>
   

    <h4> Wybierz zdjęcie</h4>
    <img src="img/<?php echo $img_source ?>" onclick="triggerClick()" id="image_display" width="400" height="300">
    <p>Zdjęcie: <?php echo $img_source; ?> </p>
    <input type="file" name="image" id="image" style="display: none;" onchange="displayImage(this)">
    <h4> Tytuł strony: </h4>
    <textarea name="page_title" id="page_title" rows="1"><?php echo $page_title;?></textarea></br>
    <h4> Meta Description: </h4>
    <textarea name="meta_description" id="meta_description" rows="2"><?php echo $meta_description;?></textarea></br>
    <button type="submit" name=<?php echo $button_name; ?>>Zapisz</button>
    <button><a href='articleslist'>Powrót</a></button>
 
    <p><?php echo $info_form; ?></p>
    <p><?php echo $info_upload; ?></p>
    <p><?php echo $info_handling; ?></p>
        

</form>
<script src="js/script.js"></script>
</body>
</html>

<?php
    } else {
    ?>
        <button><a href = 'login/loginform'>Zaloguj się</a></button>
    <?php 
        echo "Musisz się zalogować";
    }
?> 

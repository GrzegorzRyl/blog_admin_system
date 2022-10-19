<?php session_start(); ?>
<?php
include 'classes/articlesListClass.php';


$info_delete = '';
$is_logged = false;

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
}

if(isset($_GET['info_delete'])){
    $info_delete = $_GET['info_delete'];
    if($info_delete == "delete_ok"){
        $info_delete = "Poprawnie usunięto artykuł";
    }
}

if(isset($_SESSION['user'])){
    echo "Witaj: " . $_SESSION['user'];
    $is_logged = true;
?>
    <form method="post">
    <button type="submit" name="logout">Wyloguj</button>
    <button><a href = 'form'>Dodaj nowy artykuł</a></button>
    </form>

<?php
    $articles_index = "articles_index.json";
    $articles_list = new ArticlesList();
    $file_content = $articles_list -> getData($articles_index);
        echo $info_delete;
        foreach($file_content as $article => $article_value) {
?>
            <div><a href="showarticle?article_id=<?php echo $article;?>"> <h2>Tytuł: <?php echo $article_value["title"];?> </h2> </a></div>
            <?php if($article_value["last_edit"] == '') { ?>
                <div> <a>Utworzono: <?php echo $article_value["created"]; ?> </a></div></br>
            <?php } else { ?>
                <div> <a>Edycja: <?php echo $article_value["last_edit"]; ?> </a></div></br>
            <?php } ?>
            
            
            <?php if($is_logged) { ?>
                <button><a href="form?article_id=<?php echo $article;?>">Edytuj</a></button></br>
                <button><a onclick="checker()" href="deletearticle?article_id=<?php echo $article;?>">Usuń</a></button></br>
                
            <?php } 
    
        }

} else {
?>
    <button><a href = 'login/loginform'>Zaloguj się</a></button>
<?php 
    echo "Musisz się zalogować";
}
?> 

<script>
    function checker(){
    var result = confirm("Czy na pewno chcesz usunać?");
    if (result == false) {
        event.preventDefault();
    }
}
</script>

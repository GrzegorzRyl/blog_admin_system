<?php
include 'classes/articlesListClass.php';
include 'classes/deleteArticleClass.php';



$articles_index = "articles_index.json";
if(isset($_GET)){
    $article_id = $_GET['article_id'];
    $articleList = new ArticlesList();
    $file_content = $articleList -> getData($articles_index);
    $articleDelete = new DeleteArticle($article_id, $file_content, $articles_index);
    $info_delete = $articleDelete -> info_delete;
    header("Location: articleslist?info_delete=$info_delete");
}
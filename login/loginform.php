<?php session_start(); ?>
<?php
include 'loginvalidationclass.php';


$info_login = null;
$user = null;
$password = null;

if(isset($_POST['login'])){
    $user = $_POST['user'];
    $password = $_POST['password'];

    $loginValidation = new LoginValidation($user, $password);
    $info_login = $loginValidation -> info_login;

    if($info_login == 'logged'){
       
        $_SESSION["user"] = $loginValidation -> user;
        
        header("Location: ../articleslist"); //to się nie wykonuje na serwerze - rozwiązanie - wyjscie typu ECHO przed header sprawia że dalej nie można zmienić nagłówka
        //echo $_SESSION["user"];
    } else {
        session_unset();
        session_destroy();
    }
}


?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>Logowanie</title>
    </head>
<body>

<form method="post">
    <input name="user" type="text" rows="1"></input></br>
    <input type="password" name="password" rows="1"></input></br>
    <button type="submit" name="login">Zaloguj</button>
    <p><?php echo $info_login; ?></p>
</form>
</body>
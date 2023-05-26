<?php
// var_dump($_GET["id"]);
if(isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    $id = strip_tags($_GET['id']);
    $sql = "SELECT * FROM ampoules WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch();
    
if(!$result){
    header('Location: accueil.php');
}
    $sql = "DELETE FROM ampoules WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindValue('id', $id, PDO::PARAM_INT);
    $query->execute();
    require_once('close.php');
    header('Location: accueil.php');
}else{
    header('Location: accueil.php');
}

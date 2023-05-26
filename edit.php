<?php
if ($_POST) {
    if (isset($_POST['id']) && isset($_POST['la_date']) && isset($_POST['etage'])&& isset($_POST['la_position']) && isset($_POST['le_prix'])) {
        require_once('connect.php');
        $id = strip_tags($_POST['id']);
        $date = strip_tags($_POST['la_date']);
        $floor = strip_tags($_POST['etage']);
        $position = strip_tags($_POST['la_position']);
        $price = strip_tags($_POST['le_prix']);
        $sql = "UPDATE ampoules SET la_date = :la_date, etage = :etage, la_position = :la_position, le_prix = :le_prix WHERE id = :id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':la_date', $date, PDO::PARAM_STR);
        $query->bindValue(':etage', $floor, PDO::PARAM_INT);
        $query->bindValue(':la_position', $position, PDO::PARAM_STR);
        $query->bindValue(':le_prix', $price);
        $query->execute();
        require_once('close.php');
        header('location: accueil.php');
    }      
}
// var_dump($_GET["id"]);
if (isset($_GET['id']) && !empty($_GET['id'])){
    require_once('connect.php');

    $id = strip_tags($_GET['id']);
    $sql = "SELECT * FROM ampoules WHERE id = :id";
    $query = $db->prepare($sql);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    $ampoules = $query->fetch();
    

    require_once('close.php');
} else {
    header('location: accueil.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit</title>
</head>
<body>
   
<section class="edit">
        <h2>Modifier</h2>
        <form method="post">
          
            <label for="la_date"></label>
            <input type="date" value="<?=$ampoules['la_date'] ?>" name="la_date" required>
         
         
            <label for="etage"></label>
            <input type="text" value="<?=$ampoules['etage'] ?>" name="etage" required>
               
      
            <label for="la_position"></label>
            <input type="text" value="<?=$ampoules['la_position'] ?>" name="la_position" required>
              
         
            <label for="le_prix"></label>
            <input type="text" value="<?=$ampoules['le_prix'] ?>" name="le_prix" required>
           
            <input type="hidden" value="<?=$ampoules['id']?>" name="id"> 
                <input id="send" type="submit" value="Modifier">
        </form>
    </section>
</body>
</html>
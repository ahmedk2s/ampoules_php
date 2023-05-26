<?php
session_start();
if(!empty($_POST)){
    if(
        isset($_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["pass"])
        && !empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["email"]) && !empty($_POST["pass"])
    ){
        $first_name = strip_tags($_POST["first_name"]);
        $last_name = strip_tags($_POST["last_name"]);
        $_SESSION["error"] = [];

        if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
            $_SESSION["error"][] = "L'adresse email est incorrecte";
        }
        if($_SESSION["error"] === []){

            $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

            require_once("connect.php");

            $sql = "INSERT INTO utilisateurs (first_name, last_name, email, pass) VALUES (:first_name, :last_name, :email, '$pass')";

            $query = $db->prepare($sql);

            $query->bindValue(":first_name", $first_name, PDO::PARAM_STR);
            $query->bindValue(":last_name", $last_name, PDO::PARAM_STR);
            $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
            $query->execute();

            $id = $db->lastInsertId();



            $_SESSION["user"] = [
                "id" => $id,
                "first_name" => $first_name,
                "last_name" => $last_name,
                "email" => $_POST["email"],
            ];

            header("Location: index.php");
        }
    }else{
        $_SESSION["error"] = ["Le formulaire est incomplet"];
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inscription</title>
</head>

<body>
    <section class="inscri">

        <h1>Inscription</h1>
        <?php 
            if(isset($_SESSION["error"])){
                foreach($_SESSION["error"] as $message){
                    ?>
                    <p><?= $message ?></p>
                    <?php
                }
                unset($_SESSION["error"]);
            }
        ?>

        <form method="POST" action="">

            <label for="first_name"></label>
            <input type="text" id="first_name" name="first_name" placeholder="Prénom" required>

            <label for="last_name"></label>
            <input type="text" id="last_name" name="last_name" placeholder="Nom" required>

            <label for="email"></label>
            <input type="text" id="email" name="email" placeholder="E-mail" required>

            <label for="pass"></label>
            <input type="password" id="pass" name="pass" placeholder="Mot de passe">

            <input type="submit" class="send" value="Valider" name="ok">

        </form>
    </section>
</body>

</html>
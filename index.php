<?php
session_start();
if(!empty($_POST)){

    if(isset($_POST["email"], $_POST["pass"]) && !empty($_POST["email"] && !empty($_POST["pass"]))
    ){
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        die("Ce n'est pas un email");
      } 
      require_once('connect.php');
      $sql = "SELECT * FROM utilisateurs WHERE email = :email";

      $query = $db->prepare($sql);

      $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR); 

      $query->execute();

      $user = $query->fetch();

      if(!$user){
        die("L'utilisateur et/ou le mot de passe est incorrect");
      }
      if(!password_verify($_POST["pass"], $user["pass"])){
        die("L'utilisateur et/ou le mot de passe est incorrect");
      }
  
      $_SESSION["user"] = [
        "id" => $user["id"],
        "first_name" => $user["first_name"], 
        "last_name" => $user["last_name"], 
        "email" => $user["email"] 
      ];
      
      header("Location: accueil.php");
    }
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
    <title>connexion</title>
</head>
<body>
 
<section class="connex">
<h1>Connexion</h1>

<form method="POST" action="">
    <label for="email"></label>
    <input type="email" id="email" name="email" placeholder="E-mail" required>
    <label for="pass"></label>
    <input type="password" id="pass" name="pass" placeholder="Mot de passe" required>
    <input type="submit" class="send" value="Connexion" name="ok">
</form>
<a href="inscription.php">CREER UN COMPTE</a>
</section>

</body>
</html>
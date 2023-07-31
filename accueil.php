<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
var_dump($_SESSION);
if ($_POST) {
    if (
        isset($_POST['la_date'])
        && isset($_POST["etage"])
        && isset($_POST['la_position'])
        && isset($_POST['le_prix'])
    ) {
        // print_r($_POST);
        require_once('connect.php');
        $date = strip_tags($_POST['la_date']);
        $floor = strip_tags($_POST['etage']);
        $position = strip_tags($_POST['la_position']);
        $price = strip_tags($_POST['le_prix']);
        // INSERT INTO insérer des choses dans les colonnes d'une table
        $sql = "INSERT INTO ampoules (la_date, etage, la_position, le_prix) VALUES (:la_date, :etage, :la_position, :le_prix)";
        $query = $db->prepare($sql);
        $query->bindValue(":la_date", $date);
        $query->bindValue(":etage", $floor, PDO::PARAM_INT);
        $query->bindValue(":la_position", $position, PDO::PARAM_STR);
        $query->bindValue(":le_prix", $price,);
        $query->execute();
        // require_once('close.php');
        // header("location: accueil.php");
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
    <title>accueil</title>
</head>

<body>

    <ul>
       
        <li><a href="deconnexion.php">Deconnexion</a></li>
    </ul>

    <h1>Intervention ampoules</h1>

    <section class="add">
     
        <form method="post">

            <label for="la_date"></label>
            <input style="font-family: fontawesome;" type="date" name="la_date" required>

            <label for="etage"></label>
            <input style="font-family: fontawesome;" type="text" name="etage" placeholder="Etage" required>

            <label for="la_position"></label>
            <input style="font-family: fontawesome;" type="text" name="la_position" placeholder="Position" required>

            <label for="le_prix"></label>
            <input style="font-family: fontawesome;" type="text" name="le_prix" placeholder="Prix" required>

            <input class="send" type="submit" value="Ajouter">
        </form>
    </section>

    <?php
    require_once('connect.php');

    $sql = "SELECT * FROM ampoules";
    $query = $db->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <section class="history">
        <h2>Historique</h2>
        <table border="1">
            <thead>

                <th id="date">Date</th>
                <th>Etage</th>
                <th>Position</th>
                <th>Prix</th>
                <th id="actions">Actions</th>

            </thead>

            <tbody>
                <?php
                foreach ($result as $ampoules) {
                    // print_r($ampoules)
                ?>
                    <tr>

                        <td><?= $ampoules['la_date'] ?></td>
                        <td><?= $ampoules['etage'] ?></td>
                        <td><?= $ampoules['la_position'] ?></td>
                        <td><?= $ampoules['le_prix'] ?></td>
                        <td><a href="edit.php?id=<?= $ampoules['id'] ?>"><i class="fa-solid fa-file-pen"></i></a>
                            <a role="button" data-target="#modal" data-toggle="modal" class="sup" data-id="<?= $ampoules['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>

                    </tr>
                    <div class="modal" id="modal" role="dialog">
                        <div class="modal_content">
                            <div class="modal_close" data-dismiss="dialog">X</div>
                            <div class="modal_header">
                                Voulez-vous vraiment supprimer
                            </div>
                            <div class="modal_footer">
                                <a class="btn" role="button">Valider</a>
                                <a href="#" class="btn btn_close" role="button" data-dismiss="dialog">Annuler</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="modal2" role="dialog">
                        <div class="modal_content">

                            <div class="modal_header">
                                Supprimer
                            </div>

                        </div>
                    </div>
                <?php
                }
                ?>
                <tr></tr>
            </tbody>

        </table>
    </section>
    <script src="script.js"></script>
</body>

</html>
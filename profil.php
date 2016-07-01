<?php
session_start();

require 'init.php';

if(isset($_SESSION['id'])) {
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

//    echo $getid;

    $requser->closeCursor();

    $music = $bdd->prepare('SELECT * FROM music WHERE membre_id =' . $getid);
    $music->execute();
    $usermusic = $music->fetch();
//    echo '<pre>', var_dump($usermusic), '</pre>';

    $music->closeCursor();

    if(isset($_POST['submit_comment'])) {

        $commentaire = $_POST['commentaire'];

        $query = $bdd->prepare('INSERT INTO commentaires (commentaire, membre_id, receveur_id) VALUES (:commentaire, :id, :idreceveur)');
        $query->bindParam(':commentaire', $commentaire);
        $query->bindParam(':id', $_SESSION["id"]);
        $query->bindParam(':idreceveur', $getid);
        $query->execute();

    }
    ?>
    <html>
    <head>
        <title>TUTO PHP</title>
        <meta charset="utf-8">
    </head>
    <body>
    <div align="center">
        <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
        <br /><br />
        <?php
        if(!empty($userinfo['avatar']))
        {
            ?>
            <img src="membres/avatars/<?php echo $userinfo['avatar']; ?>" width="100">
            <?php
        }
        ?>
        <br>
        Pseudo = <?php echo $userinfo['pseudo']; ?>
        <br />
        Mail = <?php echo $userinfo['mail']; ?>
        <br />
        <?php
        if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
            <br />
            <a href="editionprofil.php">Editer mon profil</a>
            <a href="envoi.php">Envoyer un message</a>
            <a href="deconnexion.php">Se déconnecter</a>
            <a href="ajout_music.php">Ajout musique</a>
            <?php
        }
        ?>
    </div>

    <div class="commentaire">
        <form action="profil.php?id=<?php echo $getid ?>"method="post">
            <input type="text" name="commentaire" value="">
            <input type="submit" name="submit_comment" value="ENVOYER">
        </form>
    </div>
    </body>
    </html>
    <?php
}
?>
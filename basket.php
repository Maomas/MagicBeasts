<?php


    if(isset($_POST['homeRedirection']))
    {
        session_start();
        $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');
        header("Location: accueil.php?email=".$_SESSION['email']);
    }
    else
    {
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    /* Si on a cliqué sur le lien "vider le panier", donc qu'on a déclaré la valeur $delete dans la méthode "GET", on va supprimer dans la table commande toutes les lignes où la valeur du champ emailClient est l'adresse mail de l'utilisateur. */
    if(isset($_GET['delete']) AND !empty($_GET['delete']))
    {
        $deleteCommande = $bdd->prepare('DELETE FROM commande WHERE emailClient = ?');
        $deleteCommande->execute(array($_GET['delete']));
        header("Location: basket.php?email=".$_GET['delete']);

    }

    if(isset($_GET['email']))
    {
        /* On va récupérer toutes les commandes ajoutées au panier de l'utilisateur concerné. */
        $reqcommande = $bdd->prepare('SELECT emailClient, contain FROM commande WHERE emailClient=?');
        $reqcommande->execute(array($_GET['email']));



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Magic Beasts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css"/>
    <script src="scripts.js"></script>
</head>
<body>
    <form method="post" action=""><input class="button" type="submit" name="homeRedirection" value="Retour à l'accueil"></input></form>
    <div class="container">

    <!-- On précise à qui appartient le panier. -->
    <h2>Panier de </h2><?php echo $_GET['email']; ?>
    <div class="article">

    <!-- On va afficher le contenu de la commande tant qu'il y a des valeurs dans la variable $reqcommande. -->
    <?php while($commande = $reqcommande->fetch()) { ?>
        <p><?php echo $commande['contain']; ?></p><hr><?php } ?>
        <a href="basket.php?delete=<?php echo $_GET['email']; ?>">Vider le panier</a>
    <?php } ?>

    <?php
    } ?>
    </div>
</body>
</html>
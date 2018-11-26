<?php
   
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');
    $suppressionUser = $bdd->prepare("DELETE FROM utilisateur where email=?");
    $suppressionUser->execute(array($_GET['email']));
    header('Location: accueil.php');
?>
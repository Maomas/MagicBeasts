<?php  
    /* Démarrage de la session. */
    session_start();

    /* On tente de se connecter à la base de données "magic_beasts", avec le login 'root' et sans mot de passe. */
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');
    date_default_timezone_set('Europe/Brussels');

    /* Si il la variable "$email" obtenue par la méthode GET existe. */
    if(isset($_GET['email']))
    {
        /* On va préparer une requête pour qu'elle soit exécutée par après.  
        On va sélectionner toutes les colonnes de la table "utilisateur" où l'email est la valeur récupérée par la méthode GET. */
        $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE Email= ?');
        $requser->execute(array($_GET['email']));
        $userInfo = $requser->fetch();

        $number = floor(rand(1,1000));
        $date = date("h:i:sa");
        $email = $_GET['email'];
        $contain = "Animal : ".$_GET['race']."\nPrix : ".$_GET['price'];


        $insertCommande = $bdd->prepare('INSERT INTO commande(number, date, emailClient, contain) VALUES (?,?,?,?)');
        $insertCommande ->execute(array(
            $number,
            $date,
            $email,
            $contain
        ));
        header("Location: accueil.php?email=".$email);
    }



    
?>


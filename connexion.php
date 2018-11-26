<?php
    
    /* Démarrage d'une nouvelle session, ou restauration de celle trouvée par le serveur via une requête GET ou POST ou un cookie .*/
    session_start();

    /* Utilisation de la classe PDO pour se connecter à la base de données sur phpmyadmin. 
    Le constructeur de la classe prend en compte plusieurs paramètres :
    - 'host=localhost' : Le nom de l'hôte sur lequel se trouve la BD;
    - 'dbname=magic_beasts' : Le nom de la base de données à laquelle l'on veut accéder;
    - 'charset=utf8' : L'encodage des caractères;
    - 'root' : Le login pour s'authentifier à la BD;
    - '' : Le mot de passe pour s'authentifier à la BD.
    */
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    /* La fonction isset() détermine si une variable est affectée. 
    $_POST est un tableau associatif contenant des valeurs passées au protocole HTTP et la méthode POST.
    */
    if(isset($_POST['returnFormConnection']))
    {
        /* La fonction htmlspecialchars() permet de convertir des caractères spéciaux en entités html.  Certains caractères possèdent une siginification spéciale en html, ils doivent donc être convertis pour qu'ils conservent leur signification. 
        Par exemple, "&" devient "&amp" après la conversion effectuée par htmlspecialchar(). */
        $mailConnection = htmlspecialchars($_POST['mailConnection']);

        /* La fonction sha1() calcule le sha1 ("Secure Hash Algorithm") d'une chaine de caractères. 
        Elle permet de créer un haché de la chaine de caractères et ainsi la crypter. */
        $passwordConnection = sha1($_POST['passwordConnection']);

        /* La fonction empty() détermine si une variable est vide, donc si elle contient une valeur. */
        if(!empty($mailConnection) AND !empty($passwordConnection))
        {
            /* La fonction prepare() permet de préparer une requête à l'exécution.  
            La requête SQL passée en paramètre va sélectionner toutes les colonnes de la table Utilisateur où l'email sera égal à la variable $mailConnection 
            et le mot de passe sera égal à la variable $passwordConnection.  Les marqueurs "?" seront remplacés par les valeurs des variables lorsque la requête sera exécutée. (Ligne 36) */
            $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE Email = ? AND Password = ?');
            $requser->execute(array($mailConnection, $passwordConnection));

            /* rowCount() va compter le nombre de lignes qui a été sélectionné dans la requête SQL. */ 
            $userExist = $requser->rowCount();


            if($userExist == 1)
            {
                /* La fonction fetch() récupére le contenu de la variable $requser. */
                $userInfo = $requser->fetch();
                /* On va déclarer les variables de session en récupérant les données du tableau $userInfo, qui correspondent à aux valeurs de colonne de la ligne sélectionnée
                dans la requête préparée (ligne 35). */
                $_SESSION['name']=$userInfo['Name'];
                $_SESSION['firstName']=$userInfo['FirstName'];
                $_SESSION['email']=$userInfo['Email'];

                /* la fonction header() permet d'envoyer un en-tête HTTP, ce qui va rediriger l'utilisateur sur la page passée en paramètres. */
                header("Location: profil.php?email=".$_SESSION['email']);
            }
            else
            {
                $erreur = "Mauvais mail ou mot de passe !";
            }
        }
        else
        {
            $erreur = "Tous les champs doivent être complétés !";
        }
    }
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
    <form method="post" action="accueil"><input class="button" type="submit" value="Retour à l'accueil"></input></form>
    <div class="container">
    <h2>Connexion</h2>
    <form method="post" action="" id="formConnection">
        <label>Mail</label><br>
        <input type="email" placeholder="example@gmail.com" name="mailConnection"/><br><br>
        <label>Mot de passe</label><br>
        <input type="password" name="passwordConnection"/><br><br>
        <a href="inscription.php">Pas encore inscrit ?</a><br><br>
        <input type="submit" value="Se connecter" class="submitButton" name="returnFormConnection"/>

    </form>
    <?php
        if(isset($erreur))
        {
            echo '<font color="red">'.$erreur.'</font>';
        }      
    ?>
    </div>
</body>
</html>
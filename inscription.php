<?php

    /* Cette requête permet de se connecter à la base de données "magic_beasts" avec le nom d'utilisateur "root".  Remarque : il n'y a aucun mot de passe. */
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root',''); 

    /* Si il y a un retour du formulaire d'inscription, on exécute les instructions dans la condition. */
    if(isset($_POST['returnFormInscription']))
    {
        /* On échappe les caractères spéciaux des variables suivantes. */
        $name = htmlspecialchars($_POST['name']);
        $firstName = htmlspecialchars($_POST['firstName']);
        $email = htmlspecialchars($_POST['email']);

        /* On hache les mots de passe pour les rendre indécryptables. */
        $password = sha1($_POST['password']);
        $password2 = sha1($_POST['password2']);
        if(!empty($_POST['name']) AND !empty($_POST['firstName']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password2']))
        {
            $reqMail = $bdd->prepare("SELECT * FROM utilisateur WHERE email = ?");
            $reqMail->execute(array($email));;
            $mailExists = $reqMail->rowCount();
            if($mailExists==0)
            {
                /* Si l'utilisateur a correctement confirmé le mot de passe, la requête "insertUser" va être exécuté : On va insérer les données de l'utilisateur entrées dans le formulaire dans la table "Utilisateur". */
                if($password == $password2)
                {
                    $insertUser = $bdd->prepare("INSERT INTO utilisateur (Name, FirstName, Email, Password) VALUES (?, ?, ?, ?)");
                    $insertUser->execute(array(
                    $name,
                    $firstName,
                    $email,
                    $password
                    ));
                    header('Location: accueil.php');
                }
                else
                {
                    $erreur = "Les mots de passe ne correspondent pas !";
                }
            }
            else
            {
                $erreur = "L'adresse mail est déjà utilisée !";
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
        <!-- Le formulaire d'inscription -->
    <h2>Inscription</h2>
    <form id="formInscription" action="" method="post">
        <label>Nom</label><br>
        <input type="text" name="name" value="<?php if(isset($name)) {echo $name; }?>"/><br><br>
        <label>Prénom</label><br>
        <input type="text" name="firstName" value="<?php if(isset($firstName)) {echo $firstName;} ?>"/><br><br>
        <label>Adresse Mail</label><br>
        <input type="email" placeholder="example@gmail.com" value="<?php if(isset($email)) {echo $email;} ?>" name="email"/><br><br>
        <label>Mot de passe</label><br>
        <input type="password" name="password"/><br><br>
        <label>Confirmation du mot de passe</label><br>
        <input type="password" name="password2"><br><br>
        <!-- Le lien à la ligne 62 redirige l'utilisateur vers la page connexion.php, dans le cas où celui-ci possède déjà un compte utilisateur. -->
        <a href="connexion.php">Vous avez déjà un compte ?</a><br><br>
        <input class="submitButton" name="returnFormInscription" type="submit" value="Valider"/>
    </form>
    
    <?php
    /* Si une erreur a été détecté donc si la variable "$erreur" possède une valeur, on affiche celle-ci en rouge grâce à la balise HTML "font". */
        if(isset($erreur))
        {
            echo '<font color="red">'.$erreur.'</font>';
        }
    ?>
    </div>
</body>
</html>
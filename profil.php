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

    if(isset($_GET['email']))
    {
        $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE Email= ?');
        $requser->execute(array($_GET['email']));
        $userInfo = $requser->fetch();
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
    <h2>Profil</h2>
    <div id="profile">
        <br><br>
        Nom : <?php echo $userInfo['Name']; ?> <br><br>
        Prénom : <?php echo $userInfo['FirstName']; ?><br><br>
        Mail : <?php echo $userInfo['Email']; ?> <br><br>
        <?php
        if(isset($_SESSION['email']))
        {
            if($userInfo['Email'] == $_SESSION['email'])
            { 
        ?>
        <?php 
        if($userInfo['Email']=='samahaux98@gmail.com')
        {
            echo '<a href="administration.php">Administration</a>
            <br><br>';
        }
        else{}
        ?>
        <a href="editionProfil.php">Editer le profil</a>
        <br><br>
        <a href="deconnexion.php">Se déconnecter</a>
        <br><br>
        <a href="suppressionCompte.php?email=<?php echo $_SESSION['email']; ?>">Supprimer le compte</a>
        <br><br>
        <?php
            }
        }
        ?>
    </div>
    </div>
</body>
</html>
<?php
    }
    else
    {
    }
    }
?>